
<?php
	$dsn = 'mysql:dbname=tb2101**db;host=localhost';
	$user = 'tb-2101**';
	$password = '*********';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

$pass_master = "pass";
$pass_judge = TRUE;

if(empty($_POST["name"]) ==false && empty($_POST["com"]) == FALSE)
{if($_POST["pass_com"]=== $pass_master)
	{if(empty ($_POST["hidden_no"])== TRUE )
		{
		$time = new DateTime();
		$time = $time->format('Y-m-d H:i:s');
		$sql = $pdo -> prepare("INSERT INTO DB_submit (name, comment,time,pass) VALUES (:name,:comment,:time,:pass)");
			$sql -> bindParam(':name', $name, PDO::PARAM_STR);
			$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
			$sql -> bindValue(':time', $time , PDO::PARAM_STR);
			$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
			$name = $_POST["name"];
			$comment = $_POST["com"]; 
			$pass = $pass_master;
			$sql -> execute();
		}else
		{
			$id = $_POST["hidden_no"]; 
			$name = $_POST["name"];
			$comment = $_POST["com"]; 
			$sql = 'update DB_submit set name=:name,comment=:comment where id=:id';
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':name', $name, PDO::PARAM_STR);
			$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->execute();

		}
	}else
	{$pass_judge = FALSE;
	}
}
elseif(empty ($_POST["delno"])== FALSE)
{if($_POST["pass_del"]=== $pass_master)
	{
		$id = $_POST["delno"];
		$sql = 'delete from DB_submit where id=:id';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
	}else
	{$pass_judge = FALSE;
	}
}

elseif(empty ($_POST["editno"])== FALSE)
{if($_POST["pass_edit"]=== $pass_master)
	{$sql = 'SELECT * FROM DB_submit';
	$stmt = $pdo -> query($sql);
	$results = $stmt->fetchAll();
		foreach ($results as $row)
		{
		if ($row[0] == $_POST["editno"])
			{$editname = htmlspecialchars($row[1], ENT_QUOTES); 
			$editcom = htmlspecialchars($row[2], ENT_QUOTES); 
			$editno=htmlspecialchars($row[0], ENT_QUOTES);
			}
		}
	}else
	{$pass_judge = FALSE;
	}
}
?>
<!DOCTYPE html>
<html>  
<head>
    <meta charset="utf-8">
    <title>Mission 5-1 </title>
</head>
  <body>
<h1>すきな食べ物をおしえてください！！</h1>
<h5>パスワードは pass です</h5>
<h3>投稿</h3>
   	<form action="mission_5-1_submit.php" method="post">
<p>
 <div>
	<label for="name">Name:</label>
	<input type ="text" id="name" name="name" size="10" value="<?php if(isset($editname)){echo $editname;}?>">
 </div>
</p>
<p>
 <div>
	<label for="com">Comment:</label>
	<input type ="text" id="com" name="com" size="40" value="<?php if(isset($editcom)){echo $editcom;}?>">
 </div>
</p>
<p>
 <div>
	<label for="pass_com">Password:</label>
	<input type ="password" id="pass_com" name="pass_com" size="10">
 </div>
</p>
	<input type ="hidden" id="hidden_no" name="hidden_no" value="<?php if(isset($editno)){echo $editno;}?>">
<button type="submit" name="write" val="write">コメント</button>
	</form>
<h3>削除</h3>
  <form action="mission_5-1_submit.php" method="post">
<p>
 <div>
	<label for="delno">Delete Number:</label>
	<input type ="text" id="delno" name="delno" size="10">
 </div>
</p>
<p>
 <div>
	<label for="pass_del">Password:</label>
	<input type ="password" id="pass_del" name="pass_del" size="10">
 </div>
</p>
<button type="submit" name="del" val="del">削除</button>

	</form>
<h3>編集</h3> <!-- 3-4-1 フォームを作成-->
	<form action="mission_5-1_submit.php" method="post">
<p>
 <div>
	<label for="editno">Edit Number:</label>
	<input type ="text" id="editno" name="editno" size="10">
 </div>
</p>
<p>
 <div>
	<label for="pass_edit">Password:</label>
	<input type ="password" id="pass_edit" name="pass_edit" size="10">
 </div>
</p>
<button type="submit" name="edit" val="edit">編集番号を送信</button>
	</form>
  </body>
</html>

<?php
	$sql = 'SELECT * FROM DB_submit';
	$stmt = $pdo -> query($sql);
	$results = $stmt->fetchAll();
echo "<p>";
if($pass_judge== FALSE)
{echo "パスワードが違います"."<p>";
}elseif(empty ($_POST["hidden_no"])== FALSE)
{echo $_POST["hidden_no"]."を編集しました"."<p>";
}elseif(empty ($_POST["delno"])== FALSE)
{echo $_POST["delno"]."を削除しました"."<p>";
}elseif(empty ($_POST["editno"])== FALSE)
{echo $_POST["editno"]."を編集します"."<p>";
}

	foreach ($results as $row)
	{
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].' ';
		echo $row['name'].' ';
		echo $row['comment'].' ';
		echo $row['time'].'<br>';

	}


?>
