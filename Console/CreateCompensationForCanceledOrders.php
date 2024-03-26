<?php

namespace NobleCommerce\Reports\Console;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to create inventory compensations for canceled orders.
 */
class CreateCompensationForCanceledOrders extends Command
{
    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * Constructor
     *
     * @param ResourceConnection $resourceConnection Resource connection to execute direct queries
     */
    public function __construct(
        ResourceConnection $resourceConnection
    ) {
        parent::__construct();
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * Configuration of the command.
     */
    protected function configure()
    {
        $this->setName('noblecommerce:compensate-canceled-orders')
            ->setDescription('Create compensation for each canceled order.');
        parent::configure();
    }

    /**
     * Executes the command to generate compensation commands for canceled orders.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $connection = $this->resourceConnection->getConnection();
        $query = <<<SQL
SELECT so.increment_id, ir.sku, ABS(ir.quantity) AS quantity, ir.stock_id
FROM inventory_reservation ir
JOIN sales_order so ON JSON_UNQUOTE(JSON_EXTRACT(ir.metadata, '$.object_increment_id')) = so.increment_id
WHERE ir.quantity < 0
AND so.status = 'canceled'
SQL;
        try {
            $results = $connection->fetchAll($query);
            foreach ($results as $row) {
                $command = sprintf(
                    "inventory:reservation:create-compensation %s:%s:+%d:%d",
                    $row['increment_id'],
                    $row['sku'],
                    $row['quantity'],
                    $row['stock_id']
                );
                $output->writeln("Command to execute: $command");
                // Execute the command or log it for manual execution
            }

            if (empty($results)) {
                $output->writeln("No canceled orders found needing compensation.");
            } else {
                $output->writeln("Compensation commands generated for canceled orders.");
            }
        } catch (\Exception $e) {
            $output->writeln("<error>Error executing query: {$e->getMessage()}</error>");
            return Cli::RETURN_FAILURE;
        }

        return Cli::RETURN_SUCCESS;
    }
}
