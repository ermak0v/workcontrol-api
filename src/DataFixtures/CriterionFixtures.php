<?php

namespace App\DataFixtures;

use App\Entity\Lokr\Criterion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CriterionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $criterion = new Criterion();
        $criterion->setName('Качество работы. Количество, частота и системность ошибок и брака.');
        $criterion->setSmallName('Качество работы');
        $manager->persist($criterion);

        $criterion = new Criterion();
        $criterion->setName('Выполнение планов, разовых поручений, соблюдение сроков.');
        $criterion->setSmallName('Выполнение планов');
        $manager->persist($criterion);

        $criterion = new Criterion();
        $criterion->setName('Соблюдение технологии и порядка проведения работ, документооборота, трудовой дисциплины.');
        $criterion->setSmallName('Трудовая дисциплина');
        $manager->persist($criterion);

        $criterion = new Criterion();
        $criterion->setName('Организация, внедрения своих в нововведений в работу предприятия.');
        $criterion->setSmallName('Организация нововведений');
        $manager->persist($criterion);

        $criterion = new Criterion();
        $criterion->setName('Профессиональные знания и навыки, использование их в работе. Компетентность. Самообразование.');
        $criterion->setSmallName('Компетентность');
        $manager->persist($criterion);

        $criterion = new Criterion();
        $criterion->setName('Исполнительность работника. Готовность выполнять задания.');
        $criterion->setSmallName('Исполнительность');
        $manager->persist($criterion);

        $criterion = new Criterion();
        $criterion->setName('Выполнение требований должностной инструкции. Умение самостоятельно решать проблемы.');
        $criterion->setSmallName('Самостоятельность');
        $manager->persist($criterion);

        $criterion = new Criterion();
        $criterion->setName('Эффективная организация рабочего места и времени, производительность труда (работоспособность).');
        $criterion->setSmallName('Работоспособность');
        $manager->persist($criterion);

        $criterion = new Criterion();
        $criterion->setName('Уважение в отношениях с другими сотрудниками предприятия.');
        $criterion->setSmallName('Уважение');
        $manager->persist($criterion);

        $criterion = new Criterion();
        $criterion->setName('Взаимное доверие в отношениях с другими сотрудниками предприятия.');
        $criterion->setSmallName('Взаимное доверие');
        $manager->persist($criterion);

        $criterion = new Criterion();
        $criterion->setName('Инициативность и заинтересованность в улучшениях.');
        $criterion->setSmallName('Инициативность');
        $manager->persist($criterion);

        $manager->flush();
    }
}
