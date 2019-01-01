# portal-forms

indirmek için:
composer require Sedacelik712/portal-forms

migration:

php yii migrate/up --migrationPath=@vendor/kouosl/portal-forms/migrations

kodlarınıza eklemeyi unutmayın:

'modules' => [
   'forms' => [
            'class' => 'kouosl\forms\Module',
        ],
]


ANA SAYFA:
http://portal.kouosl/forms/forms

FORM CEVAPLARI:
kouosl database de tablo oluşturup kaydedebiliyor.

Ana sayfa:

![s](https://user-images.githubusercontent.com/38867574/50576102-8f254100-0e1b-11e9-9a68-d56889f5bc26.png)

Create Form butonuna basınca:


![s1](https://user-images.githubusercontent.com/38867574/50576124-e3c8bc00-0e1b-11e9-80e6-38ab4cafcfb7.png)

Form oluştuktan sonra formu view yapıp veri kaydetme:

![sss](https://user-images.githubusercontent.com/38867574/50576136-12469700-0e1c-11e9-9048-5a4300cb59a5.png)

List işaretine basınca verilerin sıralanması:

![ss](https://user-images.githubusercontent.com/38867574/50576154-3e621800-0e1c-11e9-828c-cbb386519686.png)
