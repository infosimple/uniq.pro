<?php

use Illuminate\Database\Seeder;

class RegionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('regions')->insert([
            ['name' => 'Россия'],
            ['name' => 'Украина'],
            ['name' => 'Беларусь'],
            ['name' => 'Казахстан'],
            ['name' => 'Архангельск'],
            ['name' => 'Астрахань'],
            ['name' => 'Барнаул'],
            ['name' => 'Белгород'],
            ['name' => 'Благовещенск'],
            ['name' => 'Брянск'],
            ['name' => 'Великий Новгород'],
            ['name' => 'Владивосток'],
            ['name' => 'Владикавказ'],
            ['name' => 'Владимир'],
            ['name' => 'Волгоград'],
            ['name' => 'Вологда'],
            ['name' => 'Воронеж'],
            ['name' => 'Грозный'],
            ['name' => 'Екатеринбург'],
            ['name' => 'Иваново'],
            ['name' => 'Иркутск'],
            ['name' => 'Йошкар-Ола'],
            ['name' => 'Казань'],
            ['name' => 'Калининград'],
            ['name' => 'Кемерово'],
            ['name' => 'Кострома'],
            ['name' => 'Краснодар'],
            ['name' => 'Красноярск'],
            ['name' => 'Курган'],
            ['name' => 'Курск'],
            ['name' => 'Липецк'],
            ['name' => 'Махачкала'],
            ['name' => 'Москва и Московская область'],
            ['name' => 'Москва'],
            ['name' => 'Мурманск'],
            ['name' => 'Назрань'],
            ['name' => 'Нальчик'],
            ['name' => 'Нижний Новгород'],
            ['name' => 'Новосибирск'],
            ['name' => 'Омск'],
            ['name' => 'Орел'],
            ['name' => 'Оренбург'],
            ['name' => 'Пенза'],
            ['name' => 'Пермь'],
            ['name' => 'Псков'],
            ['name' => 'Ростов-на-Дону'],
            ['name' => 'Рязань'],
            ['name' => 'Самара'],
            ['name' => 'Санкт-Петербург'],
            ['name' => 'Саранск'],
            ['name' => 'Смоленск'],
            ['name' => 'Сочи'],
            ['name' => 'Ставрополь'],
            ['name' => 'Сургут'],
            ['name' => 'Тамбов'],
            ['name' => 'Тверь'],
            ['name' => 'Томск'],
            ['name' => 'Тула'],
            ['name' => 'Ульяновск'],
            ['name' => 'Уфа'],
            ['name' => 'Хабаровск'],
            ['name' => 'Чебоксары'],
            ['name' => 'Челябинск'],
            ['name' => 'Черкесск'],
            ['name' => 'Ярославль']
        ]);
    }
}
