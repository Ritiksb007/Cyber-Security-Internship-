<?php
error_reporting(0);
// Form-I
$currentAlgo = "";
if(!empty($_POST))
{
	$plainText = $_POST['ptext'];
	if($_POST['sha1'] == 'SHA1')
	{
		$currentAlgo = "SHA1";
		$hashText = hash('sha1',$plainText);
		//$hashText = sha1($plainText);
	}
	elseif($_POST['md5'] == 'MD5')
		{
			$currentAlgo = "MD5";	
			$hashText = hash('md5',$plainText);
			//$hashText = md5($plainText);
		}
		elseif($_POST['sha256'] == 'SHA256')
			{
				$currentAlgo = "SHA256";	
				$hashText = hash('sha256',$plainText);		
			}
			elseif($_POST['crc32'] == 'CRC32')
				{
					$currentAlgo = "CRC32";	
					$hashText = hash('crc32',$plainText);		
				}
				elseif($_POST['tech-vegan'] == 'TECH-VEGAN')
					{
						$currentAlgo = "TECH-VEGAN";
						$hashText = hash('sha256',hash('sha1',hash('md5',hash('crc32',hash('sha256',$plainText)))));	
					}
					// Form-II
					if($_POST['enc'] == "ENCRYPT")
					{
						$plainText = $_POST['cp'];
						$output = secret('encrypt',$plainText);
					}
					
					if($_POST['dec'] == "DECRYPT")
					{
						$plainText = $_POST['cp'];
						$output = secret('decrypt',$plainText);
					}
}
function secret($type,$data)
	{
			$output = false;
			$encryptionMethod = "AES-256-CBC"; // AES-128-CBC // AES-192-CBC
			$secretKey = 'Area51';
			$secretIv = 'Area51';
			$secretKeyHash = hash('sha256',$secretKey);
			$secretIvHash = substr(hash('sha256',$secretIv),0,16);
			if($type == 'encrypt')
			{
				$output = openssl_encrypt($data, $encryptionMethod, $secretKeyHash,0,$secretIvHash);
				$output = base64_encode($output);
			}
			elseif($type == 'decrypt')
				{
					$output = openssl_decrypt(base64_decode($data), $encryptionMethod, $secretKeyHash,0,$secretIvHash);
				}
				return $output;
	}
// UNIQUE ID GENERATION
//echo uniqid();
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Cryptography</title>
  </head>
  <body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Cryptography</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Algorithms
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="index.php">SHA-1</a></li>
            <li><a class="dropdown-item" href="index.php?<?php echo sha1('crypt')."=".sha1('md5');?>">MD5</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
      </ul>

    </div>
  </div>
</nav>
<br>
<br>
<br>

<div class="container">
<p class=" display-5 border-bottom">HASH GENERATOR</p>
<form method="post" action="" name="form1" id="form1">
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label"><strong>PLAIN TEXT</strong></label>
  <input type="text" class="form-control form-control-lg" id="exampleFormControlInput1" name="ptext" placeholder="Enter Plain Text" required>
</div>
<div class="mb-3">
	<input type="submit" value="SHA1" name="sha1" class="btn btn-lg btn-success">
    <input type="submit" value="MD5" name="md5" class="btn btn-lg btn-primary">
    <input type="submit" value="SHA256" name="sha256" class="btn btn-lg btn-warning">
    <input type="submit" value="CRC32" name="crc32" class="btn btn-lg btn-dark">
    <input type="submit" value="TECH-VEGAN" name="tech-vegan" class="btn btn-lg btn-outline-success">

</div>

</form>
<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label"><strong class="display-6"><?php echo $currentAlgo."-";?>OUTPUT</strong></label>
  <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" style="font-size:40px;text-align:center;"><?php echo $hashText;?></textarea>
  </div>
  <div class="mb-3">
  <button type="button" class="btn btn-danger">
  Length <span class="badge bg-secondary"><?php echo strlen($hashText);?></span>
</button>
</div>

</div>
<br>
<br>
<br>
<hr class="border-5">
<div class="container">
<p class=" display-5 border-bottom">ENCRYPTION &amp; DECRYPTION</p>
<form method="post" action="" id="form2" name="form2">
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label"><strong>PLAIN TEXT/CIPHER TEXT</strong></label>
  <input type="text" class="form-control form-control-lg" id="exampleFormControlInput1" name="cp" placeholder="Enter Plain/Cipher Text" required>
</div>
<div class="mb-3">
	<input type="submit" value="ENCRYPT" name="enc" class="btn btn-lg btn-outline-danger">
    <input type="submit" value="DECRYPT" name="dec" class="btn btn-lg btn-outline-success">
</div>

</form>
<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label"><strong class="display-6">CIPHER TEXT</strong></label>
  <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" style="font-size:40px;"><?php echo $output;?></textarea>
  </div>
  <div class="mb-3">
  <button type="button" class="btn btn-danger">
  Length <span class="badge bg-secondary"><?php echo strlen($output);?></span>
</button>
</div>

</div>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>