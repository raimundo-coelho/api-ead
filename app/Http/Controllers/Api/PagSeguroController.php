<?php

namespace IDEALE\Http\Controllers\Api;

use Illuminate\Http\Request;
use IDEALE\Http\Controllers\Controller;

class PagSeguroController extends Controller
{

    public function createSession()
    {
        \PagSeguro\Library::initialize();
        \PagSeguro\Library::cmsVersion()->setName("Instituto Beleza VIP")->setRelease("1.0.0");
        \PagSeguro\Library::moduleVersion()->setName("Instituto Beleza VIP")->setRelease("1.0.0");

        \PagSeguro\Configuration\Configure::setEnvironment('sandbox');//production or sandbox
        \PagSeguro\Configuration\Configure::setAccountCredentials(
            'contato.rcoelho@gmail.com',
            '7EA484E458984B458A20277A3BB1AF9A'
        );
        \PagSeguro\Configuration\Configure::setCharset('UTF-8');// UTF-8 or ISO-8859-1
        \PagSeguro\Configuration\Configure::setLog(true, storage_path('logs/pagseguro_'. date('Ymd') .'.txt'));

        try {
            $sessionCode = \PagSeguro\Services\Session::create(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );
            echo json_encode([
                'sessionId' => $sessionCode->getResult()
            ]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }


    function switchPayment(Request $request)
    {
        $data = $request->all();
        $method = $data['method'];
        $items = $data['items'];
        $hash = $data['hash'];
        $total = $data['total'];
        $token = $data['token'] ?? null; //isset($data['token']) ? $data['token']:null

        if ($method == 'BOLETO') {
            $this->paymentWithBankSlip($items,$hash,$total);
        } elseif ($method == 'CREDIT_CARD') {
            $this->paymentWithCreditCard($items,$hash,$total,$token);
        }
    }

    function paymentWithCreditCard($items,$hash,$total,$token)
    {

        putenv('PAGSEGURO_EMAIL=contato.rcoelho@gmail.com');
        putenv('PAGSEGURO_TOKEN_SANDBOX=7EA484E458984B458A20277A3BB1AF9A');
        putenv('PAGSEGURO_ENV=sandbox');

        \PagSeguro\Library::initialize();
        \PagSeguro\Library::cmsVersion()->setName("Inst. Beleza VIP")->setRelease("10.0.1");
        \PagSeguro\Library::moduleVersion()->setName("Inst. Beleza VIP")->setRelease("10.0.2");


        $creditCard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();
        $creditCard->setMode('DEFAULT');

        $creditCard->setCurrency('BRL');

        foreach ($items as $key => $item) {
            $creditCard
                ->addItems()
                ->withParameters("00$key", $item['name'], 1, $item['price']);
        }

        $creditCard->setSender()
            ->setName('Fulaninho de tal')
            ->setEmail('fulaninho@sandbox.pagseguro.com.br')
            ->setPhone()->withParameters('11', '11111111');

        $creditCard->setSender()->setDocument()->withParameters('CPF', '156.009.442-76');
        $creditCard->setSender()->setHash($hash);
        $creditCard->setInstallment()->withParameters(1, $total);

        $creditCard->setShipping()
            ->setAddress()->withParameters(
                'Chiquito Gazola',
                '1233',
                'Coronel almeida',
                '01452002',
                'Parana Paulo',
                'SP',
                'BRA',
                'apto. 541'
            );

        $creditCard->setBilling()
            ->setAddress()->withParameters(
                'Chiquito Gazola',
                '1233',
                'Coronel almeida',
                '01452002',
                'Parana Paulo',
                'SP',
                'BRA',
                'apto. 541'
            );

        $creditCard->setToken($token);

        $creditCard->setHolder()->setName('Fulaninho de tal');
        $creditCard->setHolder()->setBirthDate(date('01/01/2000'));
        $creditCard->setHolder()->setPhone()->withParameters('11', '11111111');
        $creditCard->setHolder()->setDocument()->withParameters('CPF', '156.009.442-76');

        $result = $creditCard->register(\PagSeguro\Configuration\Configure::getAccountCredentials());
        echo json_encode([
            'code' => $result->getCode()
        ]);


    }


    function paymentWithBankSlip($items,$hash, $total)
    {
        $bankSlip = new \PagSeguro\Domains\Requests\DirectPayment\Boleto();
        $bankSlip->setMode('DEFAULT');
        $bankSlip->setReference('Compra na loja da SON');
        $bankSlip->setReceiverEmail('coloque o e-mail da sua conta aqui ou e-mail do comprador de testes');
        $bankSlip->setCurrency('BRL');



        foreach ($items as $key => $item) {
            $bankSlip
                ->addItems()
                ->withParameters("00$key", $item['name'], 1, $item['price']);
        }

        $bankSlip->setSender()
            ->setName('Fulaninho de tal')
            ->setEmail('fulaninho@sandbox.pagseguro.com.br')
            ->setPhone()->withParameters('11', '11111111');

        $bankSlip->setSender()->setDocument()->withParameters('CPF', '156.009.442-76');
        $bankSlip->setSender()->setHash($hash);

        $bankSlip->setShipping()
            ->setAddress()->withParameters(
                'Av. Brig. Faria Lima',
                '1384',
                'Jardim Paulistano',
                '01452002',
                'São Paulo',
                'SP',
                'BRA',
                'apto. 114'
            );

        $result = $bankSlip->register(\PagSeguro\Configuration\Configure::getAccountCredentials());
        echo json_encode([
            'code' => $result->getCode(),
            'link' => $result->getPaymentLink()
        ]);
    }
}