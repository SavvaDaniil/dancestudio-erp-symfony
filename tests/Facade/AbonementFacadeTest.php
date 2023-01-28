<?php

//use PHPUnit\Framework\TestCase;

//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use Doctrine\Persistence\ManagerRegistry;
use App\DTO\Abonement\AbonementNewDTO;
use App\DTO\Abonement\AbonementEditByColumnDTO;
//use App\Model\Abonement\AbonementSpecialStatus;
use App\Facade\AbonementFacade;
use App\Entity\Abonement;

final class AbonementFacadeTest extends KernelTestCase {

    private AbonementFacade $abonementFacade;

    protected function setUp(): void
    {
        self::bootKernel();
        //$this->jWTEncoder = self::$container->get('App\Services\TokenProvider');
        $container = static::getContainer();
        $this->abonementFacade = $container->get("App\Facade\AbonementFacade");
    }

    public function testGenerateNewAbonementByDTO(): void {

        //$doctrine = AbstractController::getDoctrine();
        //$doctrine = $this->createMock(AbonementFacade::class);
        //$abonementFacade = $this->createMock(AbonementFacade::class);

        //$abonementSpecialStatus = AbonementSpecialStatus::RAZ;
        $abonementNewMock = new Abonement();
        $abonementNewMock->setName("Default raz");
        $abonementNewMock->setSpecialStatus("raz");
        $abonementNewMock->setIsTrial(0);
        //if($abonementSpecialStatus == AbonementSpecialStatus::RAZ){
        $abonementNewMock->setDays(1);
        $abonementNewMock->setVisits(1);
        //}

        $abonementNewDTO = new AbonementNewDTO("raz", false);

        $this->assertEquals($this->abonementFacade->generateNewByDTO($abonementNewDTO), $abonementNewMock, "Ошибка про генерации нового абонемента");
    }

    public function testEditByColumnDTO(): void {

        $abonementNewMock = new Abonement();
        $abonementNewMock->setName("Default raz");
        $abonementNewMock->setSpecialStatus("raz");
        $abonementNewMock->setIsTrial(0);
        $abonementNewMock->setDays(1);
        $abonementNewMock->setVisits(1);

        $abonementWithChanges = clone $abonementNewMock;
        $abonementWithChanges->setName("Default 2");
        $this->assertEquals($this->abonementFacade->editByColumn($abonementNewMock, "name", "Default 2"), $abonementWithChanges, "Редактирование абонемента не сработало");
        $abonementWithChanges->setVisits(2);
        $this->assertEquals($this->abonementFacade->editByColumn($abonementNewMock, "visits", "2"), $abonementWithChanges, "Редактирование абонемента не сработало");
    }
}