<!DOCTYPE html>
<html>

<head>
    <title> Print berkas </title>
</head>

<body>
    <center>
        <h2>DATA</h2>
    </center>

    <?php
    include 'index.php'
    ?>
    <table class="table table-striped table-hover table-border">
        <tr>
            <th width="1%">No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Asal Barang</th>
            <th>Jumlah</th>
            <th>Tanggal Diterima</th>
        </tr>
        <?php
        $no = 1;
        $sql = mysqli_query($koneksi, "SELECT * FROM tbarang");
        $data = mysqli_fetch_array($sql); {
        ?>
            <tr>
                <td>
                    <?php echo $no++; ?>
                </td>
                <td>
                    <?php echo $data['kode']; ?>
                </td>
                <td>
                    <?php echo $data['nama']; ?>
                </td>
                <td>
                    <?php echo $data['asal']; ?>
                </td>
                <td>
                    <?php echo $data['jumlah']; ?>
                </td>
                <td>
                    <?php echo $data['tanggal_diterima']; ?>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
    <script>
        window.print()
    </script>
</body>

</html>