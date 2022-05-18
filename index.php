<?php
// ���������� �������� ���������� ���������,
// ���� index.php ������ ���� � ��������� UTF-8 ��� BOM.
header('Content-Type: text/html; charset=UTF-8');

// � ��������������� ������� $_SERVER PHP ��������� �������� ��������� ������� HTTP
// � ������ �������� � �������� � �������, �������� ����� �������� ������� $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // � ��������������� ������� $_GET PHP ������ ��� ���������, ���������� � ������� ������� ����� URL.
  if (!empty($_GET['save'])) {
    // ���� ���� �������� save, �� ������� ��������� ������������.
    print('�������, ���������� ���������.');
  }
  // �������� ���������� ����� form.php.
  include('form.php');
  // ��������� ������ �������.
  exit();
}
// �����, ���� ������ ��� ������� POST, �.�. ����� ��������� ������ � ��������� �� � XML-����.

// ��������� ������.
$errors = FALSE;
if (empty($_POST['name'])) {
  print('��������� ���.<br/>');
  $errors = TRUE;
}
if (!preg_match("/^[a-z�-��]+$/i", $_POST['name'])){
	echo "<script> alert('������� ������ ����� � ���� ���.');</script>";
$errors = TRUE;
}


if (empty($_POST['email'])) {
  print('��������� email.<br/>');
  $errors = TRUE;
}

if (!preg_match("/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/", $_POST['email'])){
  echo "<script> alert('����������� email.');</script>";
  $errors = TRUE;
}


if (empty($_POST['bio'])) {
  print('��������� ���������.<br/>');
  $errors = TRUE;
}
if ($errors) {
  // ��� ������� ������ ��������� ������ �������.
  exit();
}


$user = 'u47590';
$pass = '3205407';
$db = new PDO('mysql:host=localhost;dbname=u47590', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

try {
  $stmt = $db->prepare("INSERT INTO application (name, email, year, sex, limbs, ability_immortality, ability_pass_thr_walls, ability_levitation, bio, checkbox ) 
  VALUES (:name, :email, :year, :sex, :limbs, :imm, :walls, :lev, :bio, :checkbox)");
  $stmt -> bindParam(':name', $name);
  $stmt -> bindParam(':email', $email);
  $stmt -> bindParam(':year', $year);
  $stmt -> bindParam(':sex', $sex);
  $stmt -> bindParam(':limbs', $limbs);
  $stmt -> bindParam(':imm', $imm);
  $stmt -> bindParam(':walls', $walls);
  $stmt -> bindParam(':lev', $lev);
  $stmt -> bindParam(':bio', $bio);
  $stmt -> bindParam(':checkbox', $checkbox);

  $name = $_POST['name'];
  $email = $_POST['email'];
  $year = $_POST['year'];
  $sex = $_POST['radio-group-1'];
  $limbs = $_POST['radio-group-2'];
	
   $imm = $_POST['power'];
   $walls = $_POST['power'];
   $lev = $_POST['power'];
	
  $bio = $_POST['bio'];

  if (empty($_POST['check-1']))
    $checkbox = "No";
  else
    $checkbox = $_POST['check-1'];

  
  $stmt -> execute();
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}

header('Location: ?save=1');