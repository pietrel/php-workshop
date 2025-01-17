```php
/**
* @requires PHP == 6.0
*/
public function testGetListOfArticles(){}

```

Ta adnotacja oznacza, że test może być uruchomiony tylko wtedy,
gdy wersja PHP używana do uruchomienia testów jest dokładnie 6.0.
Jeśli wersja PHP różni się od wymaganej, test zostanie pominięty.

W tym przypadku ograniczenie do wersji PHP 6.0 pozwala na pominięcie testu,
ponieważ wersja PHP 6 nigdy nie została oficjalnie wydana.

Tego typu adnotacje są używane, aby ograniczyć uruchamianie testów
do określonych środowisk, np. w przypadku testowania funkcjonalności, które są dostępne tylko w określonej wersji PHP.

Adnotacja @requires może być używana nie tylko dla wersji PHP, ale również dla rozszerzeń PHP, np.:

```php
/**
* @requires extension mysqli
**/
```

```php

/**
 * @runInSeparateProcess
 * @preserveGlobalState disabled
 */
public function testNativeAdsTU(){}


```

`@runInSeparateProcess`

Ta adnotacja informuje PHPUnit, aby uruchomił test w osobnym procesie PHP.
Zapewnia to, że test działa w izolacji od innych testów, co zapobiega skutkom
ubocznym wynikającym ze zmian w stanie globalnym, takich jak modyfikacja
zmiennych globalnych, stałych czy superglobali.

`@preserveGlobalState disabled`

W połączeniu z @runInSeparateProcess wyłącza zachowanie stanu globalnego
między procesem nadrzędnym (gdzie działa PHPUnit) a procesem podrzędnym
(gdzie działa test).
Oznacza to, że wszelkie zmiany w zmiennych globalnych, stałych czy
właściwościach statycznych w teście nie wpłyną na proces nadrzędny ani na kolejne testy.

Kombinacja tych adnotacji jest często stosowana podczas testowania kodu, który wchodzi w interakcję
z wewnętrznymi mechanizmami PHP, stanem globalnym lub zewnętrznymi bibliotekami w sposób, który mógłby zakłócać inne testy.
Uruchamianie testu w osobnym procesie zapewnia niezawodność i zapobiega trudnym do zdiagnozowania problemom.

- Działa w czystym, izolowanym procesie.
- Zapobiega skutkom ubocznym wynikającym ze zmian w stanie globalnym.
- Prawdopodobnie testuje konkretny aspekt związany z „reklamami natywnymi”.
  Mock to zamiennik zależności, która jest wykorzystywana, ale w danym teście nie ma być używana.
  Najczęściej używanym przykładem może być baza danych lub komunikacja z zewnętrznym API.

W testach jednostkowych nie chcesz faktycznie uzyskiwać dostępu do bazy danych.
Zamiast tego chcesz zamockować użycie bazy danych, aby móc przetestować swoją logikę bez jej udziału.
Są na to dwa powody: szybkość i izolacja.

Zacznijmy od szybkości – testy jednostkowe muszą być szybkie.
Jeśli test jednostkowy zajmuje więcej niż kilka milisekund to wielokrotne powórzenie powoduje znaczący czas testowania.
W większym projekcie prawdopodobnie będziesz mieć tysiące, jeśli nie dziesiątki tysięcy testów jednostkowych.
Gdyby każdy z nich musiał komunikować się z bazą danych, a następnie ją resetować, cały zestaw testów zajmowałby godziny.

Innym powodem stosowania mocków jest testowanie kodu w izolacji.
Zasadniczo chcemy, aby nasze testy jednostkowe sprawdzały jedną rzecz.
Nie interesuje nas więc, co robią inne klasy "pod maską" – ich zachowanie jest pokryte ich własnymi testami jednostkowymi.
Weźmy na przykład poniższy kod. Pobieramy dane i upewniamy się, że status jest OK.
W teście jednostkowym nie chcemy używać klasy HttpFetcher, zamiast tego zamockujemy ją i przetestujemy jedynie sprawdzanie statusu.

## Mocks and Stubs

W PHP, gdy mówimy o mockach, warto rozróżnić dwa rodzaje: mocki i stuby.
Różnica między nimi polega na tym, co możemy z nimi zrobić.
Stuba używamy, aby skonfigurować jego zachowanie, na przykład określić, jaką wartość ma zwrócić przy wywołaniu konkretnej metody.
Mock działa podobnie, ale dodatkowo pozwala nam ustawiać oczekiwania – możemy na przykład sprawdzić, czy dana metoda została wywołana dwa razy lub z określonymi parametrami.

Jeśli zależy Ci na przetestowaniu „efektu ubocznego” działania metody, użyj mocka.
W przeciwnym razie lepiej sprawdzi się stub.

Dla przykładu: jeśli masz metodę, która musi wykonać wywołanie API z bardzo konkretnymi parametrami, użyj mocka, aby upewnić się, że wywołanie odbyło się zgodnie z oczekiwaniami.
Natomiast jeśli metoda jedynie pobiera dane od zewnętrznej zależności, wystarczy użyć stuba.

Ogólnie rzecz biorąc, zawsze warto sięgać po stuba, chyba że naprawdę musisz przetestować, czy konkretne wywołanie miało miejsce.
Mock powinien być używany tylko w sytuacjach, gdy jest to absolutnie konieczne.

```php

class TestedSubject
{

    public function __construct(
        private HttpClient $client,
    ) {}


    public function handle(): array
    {
        $response = $this-client->request();

        if($response->status !== 'OK') {
            throw new Exception('Status was not OK.);
        }

        return $response;
    } 
}
```

Ta implementacje będzie próbowała wykorzystać koumunikację z zewnętrznym API.

```php
class TestedSubjectTest extends TestCase
{
  ppublic function testReturnType(): void
    {
        $subject = new TestedSubject(new HttpClient());

        $response = $subject->handle();

        $this->assertEqauls('OK', $response->status);
    }
}
```

W tym przypadku, ponieważ nie jest istotne, ile razy coś zostało wywołane ani z jakimi parametrami, nie musimy używać mocka – wystarczy stub.

```php
class TestedSubjectTest extends TestCase
{

    public function testReturnType(): void
    {
        $client = $this->createStub(HttpClient::class);
        $client->method('request')
            ->willReturn((object)['status' => 'OK']);

        $subject = new TestedSubject($client);

        $response = $subject->handle();

        $this->assertEquals('OK', $data->status);
    }
}

```

W tym przypadku checmy sprawdzić czy dana metoda została wywołana dokładnie raz.


```php
class TestedSubjectTest extends TestCase
{

    public function testReturnType(): void
    {
        $client = $this->createMock(HttpClient::class);
        $client->expects($this->once())
            ->method('request')
            ->willReturn((object)['status' => 'OK']);

        $subject = new TestedSubject($client);

        $response = $subject->handle();

        $this->assertEquals('OK', $data->status);
    }
}

```

```php
$this->once()
$this->exactly(1)
$this->never()
```

```php

class AuthTest extends TestCase
{
    /**
     * Test unauthorized
     *
     * @return void
     */
    public function testUnauthorized()
    {
        $response = $this->json('GET', '/auth/user');

        $response
            ->assertJson([
                'errors' => [
                    ['message' => 'HTTP_FORBIDDEN'],
                ],
            ])
            ->assertStatus(403);
    }

    /**
     * Test authorized
     *
     * @return void
     */
    public function testAuthorized()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api')
            ->json('GET', '/auth/user')
            ->assertJson([
                'user_id' => $user->id,
                'email' => $user->email,
            ])
            ->assertStatus(200);
    }
}

```

```php

class ChargeTest extends TestCase
{
    public function testExceptionUnknownGroupType()
    {
        /** @var Group $group */
        $group = factory(Group::class)->create([
            'invoice_type' => 'foo-bar',
            'next_due_date' => now()->startOfMonth(),
            'last_payment_at' => null,
            'product_id' => factory(Product::class)->create()->getKey(),
            'customer_id' => factory(Customer::class)->create()->getKey(),
        ]);

        $this->expectException(ChargeException::class);

        app()->make(Charge::class)
            ->execute($group);
    }
}
```

```php

class DeleteTest extends TestCase
{
    public function testSoftDeleteObject()
    {
        Storage::fake('objects');
 
        $this->mock(ObjectService::class, function ($mock) {
            $mock->shouldReceive('upload')->once()->andReturn(Stub::load('obj-upload.json'));
            $mock->shouldReceive('delete')->once()->andReturn(Stub::load('obj-delete.json'));
        });

        $createObject = app()->make(Create::class)
            ->by(factory(Author::class)->create())
            ->execute(
                [
                    'title' => 'Foo',
                    'description' => 'Bar',
                    'published_at' => now(),
                    'require_subscription' => false,
                    'file' => UploadedFile::fake()->create('my-awesome-object.obj'),
                ]
            );

        $deleteObject = app()->make(Delete::class)
            ->execute($createObject->file);

        $this->assertTrue($deleteObject->success);

        $this->assertDatabaseMissing(
            'object_streams',
            ['object_id' => $createObject->file->id]
        );

        Storage::disk('objects')->assertExists($createObject->file->path);
        $this->assertSoftDeleted('objects', $createObject->file->getAttributes());
    }
}


```

```php

class SlackServiceTest extends TestCase
{
    public function testSendToSlackClient()
    {
        $this->mock(Service::class, function ($mock) {
            $mock->shouldReceive('send')->once()->andReturn(true);
        });

        $sender = app()->make(\Services\Slack\Sender::class);
        $sender->sendToSlack('Test message', Sites::TU);
    }
}

```