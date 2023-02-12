<?php

declare(strict_types=1);

namespace EasyCorp\Bundle\EasyAdminBundle\Test\Trait;

// TODO : implement TODOs
use function PHPUnit\Framework\assertCount;

trait CrudTestAsserts
{
    protected static function assertIndexFullEntityCount(int $expectedIndexFullEntityCount, string $message = ''): void
    {
        if (0 > $expectedIndexFullEntityCount) {
            throw new \InvalidArgumentException();
        }

        if (0 === $expectedIndexFullEntityCount) {
            $message = '' !== $message ? $message : 'There should be no results found in the index table';
            static::assertSelectorTextSame('.no-results', 'No results found.', $message);
        } else {
            $message = '' !== $message ? $message : sprintf('There should be a total of %d results found in the index table', $expectedIndexFullEntityCount);
            static::assertSelectorNotExists('.no-results');
            static::assertSelectorTextSame('.list-pagination-counter strong', (string) $expectedIndexFullEntityCount, $message);
        }
    }

    protected function assertIndexPageEntityCount(int $expectedIndexPageEntityCount, string $message = ''): void
    {
        if (0 > $expectedIndexPageEntityCount) {
            throw new \InvalidArgumentException();
        }

        if (0 === $expectedIndexPageEntityCount) {
            $message = '' !== $message ? $message : 'There should be no results found in the index table';
            static::assertSelectorExists('tr.no-results', $message);
        } else {
            $message = '' !== $message ? $message : sprintf('There should be %d results found in the current index page', $expectedIndexPageEntityCount);
            static::assertSelectorNotExists('tr.no-results', );
            static::assertSelectorExists('tbody tr');
            $indexPageEntityRows = $this->client->getCrawler()->filter('tbody tr');
            static::assertEquals($expectedIndexPageEntityCount, $indexPageEntityRows->count(), $message);
        }
    }

    protected function assertIndexPagesCount(int $expectedIndexPagesCount, string $message = ''): void
    {
        if (0 >= $expectedIndexPagesCount) {
            throw new \InvalidArgumentException();
        }

        $crawler = $this->client->getCrawler();
        $message = '' !== $message ? $message : sprintf('There should be a total of %d pages in the index page', $expectedIndexPagesCount);

        $pageItemsSelector = '.list-pagination-paginator ul.pagination li.page-item';
        static::assertSelectorExists($pageItemsSelector);

        $pageItems = $crawler->filter($pageItemsSelector);
        $lastNumberedPageItem = $pageItems->slice($pageItems->count() - 2, 1);
        static::assertEquals((string) $expectedIndexPagesCount, $lastNumberedPageItem->filter('a')->text(), $message);
    }

    protected function assertIndexEntityActionExistsForEntity(string $action, string|int $entityId, string $message = ''): void
    {
        $message = '' === $message ? sprintf('The action %s has not been found for entity id %s', $action, (string) $entityId) : $message;

        $entityRow = $this->client->getCrawler()->filter(sprintf('tbody tr[data-id=%s]', (string) $entityId));
        self::assertCount(1, $entityRow, sprintf('The entity %s is not existing in the table', (string) $entityId));

        $action = $entityRow->first()->filter(sprintf('.action-%s', $action));
        assertCount(1, $action, $message);
    }

    protected function assertNotIndexEntityActionExistsForEntity(string $action, string|int $entityId, string $message = ''): void
    {
        $message = '' === $message ? sprintf('The action %s has been found for entity id %s', $action, (string) $entityId) : $message;

        $entityRow = $this->client->getCrawler()->filter(sprintf('tbody tr[data-id=%s]', (string) $entityId));
        self::assertCount(1, $entityRow, sprintf('The entity %s is not existing in the table', (string) $entityId));

        $action = $entityRow->first()->filter(sprintf('.action-%s', $action));
        assertCount(0, $action, $message);
    }

    protected function assertGlobalActionExists(string $action): void
    {
        // TODO : to implement
    }

    protected function assertNotGlobalActionExists(string $action): void
    {
        // TODO : to implement
    }

    protected function assertColumnExists(string $columnName): void
    {
        // TODO : to implement
    }

    protected function assertNotColumnExists(string $columnName): void
    {
        // TODO : to implement
    }

    protected function assertColumnHeaderContains(string $columnName, string $columnHeaderValue): void
    {
        // TODO : to implement
    }

    protected function assertNotColumnHeaderContains(string $columnName, string $columnHeaderValue): void
    {
        // TODO : to implement
    }
}
