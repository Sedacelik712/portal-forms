# portal-forms
Assets ve FormBase kısımları için kaynak:https://github.com/pceuropa/yii2-forms

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

![m](https://user-images.githubusercontent.com/38867574/50660254-30dd9700-0fb0-11e9-87e2-c4592fbb759c.png)

Create Form butonuna basınca:


![s1](https://user-images.githubusercontent.com/38867574/50576124-e3c8bc00-0e1b-11e9-80e6-38ab4cafcfb7.png)

Form oluştuktan sonra formu view yapıp veri kaydetme:

![sss](https://user-images.githubusercontent.com/38867574/50576136-12469700-0e1c-11e9-9048-5a4300cb59a5.png)

List işaretine basınca verilerin sıralanması:

![ss](https://user-images.githubusercontent.com/38867574/50576154-3e621800-0e1c-11e9-828c-cbb386519686.png)
