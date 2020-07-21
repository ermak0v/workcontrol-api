<?php

namespace App\DataFixtures;

use App\Entity\Criterion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CriterionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $criterion = new Criterion();
        $criterion->setName('Качество работы. Количество, частота и системность ошибок и брака.');
        $manager->persist($criterion);

        $criterion = new Criterion();
        $criterion->setName('Выполнение планов, разовых поручений, соблюдение сроков.');
        $manager->persist($criterion);

        $criterion = new Criterion();
        $criterion->setName('Соблюдение технологии и порядка проведения работ, документооборота, трудовой дисциплины.');
        $manager->persist($criterion);

        $criterion = new Criterion();
        $criterion->setName('Организация внедрения своих в нововведений в работу предприятия.');
        $manager->persist($criterion);

        $criterion = new Criterion();
        $criterion->setName('Профессиональные знания и навыки, использование их в работе. Компетентность. Самообразование.');
        $manager->persist($criterion);

        $criterion = new Criterion();
        $criterion->setName('Исполнительность работника Готовность выполнять задания.');
        $manager->persist($criterion);

        $criterion = new Criterion();
        $criterion->setName('Выполнение требований должностной инструкции. Умение самостоятельно решать проблемы.');
        $manager->persist($criterion);

        $criterion = new Criterion();
        $criterion->setName('Эффективная  организация рабочего места и времени, производительность труда (работоспособность).');
        $manager->persist($criterion);

        $criterion = new Criterion();
        $criterion->setName('Уважение  в отношениях с другими сотрудниками предприятия.');
        $manager->persist($criterion);

        $criterion = new Criterion();
        $criterion->setName('Взаимное  доверие в отношениях с другими сотрудниками предприятия.');
        $manager->persist($criterion);

        $criterion = new Criterion();
        $criterion->setName('Инициативность и заинтересованность в улучшениях.');
        $manager->persist($criterion);

        $manager->flush();
    }
}
