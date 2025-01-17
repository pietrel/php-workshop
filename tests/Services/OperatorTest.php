<?php

use Tests\BaseTestCase;
use Workshop\Services\Operator\Operator;

/**
 * Test zazwyczaj opiera się na strukturze „Arrange, Act, Assert”:
 * - przygotowanie wszystkich niezbędnych warunków wstępnych i danych wejściowych
 * - wykonanie działania na obiekcie testowanym
 * - sprawdzenie, czy oczekiwane wyniki zostały osiągnięte.
 * W przypadku oczekiwania na wyjątek “Arrange, Expect, Act”
 */
class OperatorTest extends BaseTestCase
{
    private Operator|null $operator;

    /**
     * Przed każdym testem metoda setUp() jest wywoływana automatycznie.
     * Pozwala to na przygotowanie środowiska testowego.
     */
    protected function setUp(): void
    {
        $this->operator = new Operator();
    }

    public static function setUpBeforeClass(): void
    {
    }

    /**
     * Po każdym teście metoda tearDown() jest wywoływana automatycznie.
     * Pozwala to na zwolnienie zasobów, które mogłyby być zajęte przez test.
     * W praktyce rzadko jest używana, ponieważ PHPUnit automatycznie zwalnia zasoby po zakończeniu testu.
     * Jednak w niektórych przypadkach może być przydatna.
     * Na przykład, jeśli test tworzy plik, który musi zostać usunięty po zakończeniu testu.
     */
    protected function tearDown(): void
    {
        $this->operator = null;
    }

    public static function tearDownAfterClass(): void
    {
    }

    public static function parameterProvider(): array
    {
        return [
            [2, 3],
            [5, 6],
        ];
    }

    /**
     * @dataProvider parameterProvider
     */
    public function testOperation($parameter, $result): void
    {
        $this->assertSame($result, $this->operator->operation($parameter));
    }

    public function testOperationThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalida argument.');
        $this->operator->operation(0);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testHistoryIsLogged(): void
    {
        $this->operator->operation(1);
        $this->operator->operation(2);

        $history = $this->operator->getHistory();
        $this->assertCount(2, $history);
        $this->assertSame([
            'operation' => 'operation-1',
            'parameter' => 1,
            'result'    => 2,
        ], $history[0]);

        $this->assertSame([
            'operation' => 'operation-1',
            'parameter' => 2,
            'result'    => 3,
        ], $history[1]);
    }
}
