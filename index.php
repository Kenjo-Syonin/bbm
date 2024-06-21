<?php
session_start();

class Tiket {
    private $harga;
    private $jumlah;
    private $jenis;
    private $ppn;

    public function __construct($jenis, $jumlah) {
        $this->jenis = $jenis;
        $this->jumlah = $jumlah;
        $this->setHarga();
        $this->setPpn();
    }

    private function setHarga() {
        switch ($this->jenis) {
            case 'Shell':
                $this->harga = 700000;
                break;
            case 'Pertalite':
                $this->harga = 1300000;
                break;
            case 'Pertamax':
                $this->harga = 2000000;
                break;
            case 'Turbo':
                $this->harga = 2700000;
                break;
        }
    }

    private function setPpn() {
        $this->ppn = $this->harga * $this->jumlah * 0.1;
    }

    public function getHarga() {
        return $this->harga;
    }

    public function getJumlah() {
        return $this->jumlah;
    }

    public function getJenis() {
        return $this->jenis;
    }

    public function getPpn() {
        return $this->ppn;
    }
}

class Bayar extends Tiket {
    public function __construct($jenis, $jumlah) {
        parent::__construct($jenis, $jumlah);   
    }

    public function getBuktiTransaksi() {
        $total = $this->getHarga() * $this->getJumlah() + $this->getPpn();
        return "Anda membeli bbm ". $this->getJenis(). "<br>Sebanyak ". $this->getJumlah(). " liter <br>Total yang harus anda bayar Rp. ". number_format($total, 0, ',', '.');
    }
}

if (isset($_POST['jenis']) && isset($_POST['jumlah'])) {
    $jenis = $_POST['jenis'];
    $jumlah = $_POST['jumlah'];
    $_SESSION['tiket'] = new Bayar($jenis, $jumlah);
}

if (isset($_SESSION['tiket'])) {
    $buktiTransaksi = $_SESSION['tiket']->getBuktiTransaksi();
} 
else {
    $buktiTransaksi = '';
}

?>
<html>
<head>
    <title>BBM</title>
    <style>
        body{
            height:100vh;
            display:flex;
            flex-direction:column;
            align-items: center;
        }
       .border-box {
            border-top: 3px dashed black;
            border-bottom: 3px dashed black;
            padding: 10px;
        }
    </style>
</head>
<body>
    <h1>BBM</h1>
    <form action="" method="post">
        <label for="jenis">Jenis BBM:</label>
        <select name="jenis" id="jenis">
            <option value="Shell">Shell</option>
            <option value="Pertalite">Pertalite</option>
            <option value="Pertamax">Pertamax</option>
            <option value="Turbo">Turbo</option>
        </select>
        <br><br>
        <label for="jumlah">Jumlah (liter):</label>
        <input type="number" name="jumlah" id="jumlah" value="1">
        <br><br>
        <button type="submit" value="Beli">Beli</button>
    </form>

    <?php if (!empty($buktiTransaksi)):?>
    <div class="border-box">
        <?= $buktiTransaksi?>
    </div>
    <?php endif;?>
</body>
</html>