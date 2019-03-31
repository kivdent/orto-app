<?php
$ThisVU="stms";
$this->title="Материалы"; 
$js="spisok"; 
//include("header.php");
echo " <script language='JavaScript' type='text/javascript'>
					  function dis1()
					  {
					  	document.addcat.QPack.disabled='disabled';
						document.addcat.QPrice.disabled='disabled';
						document.addcat.Price.disabled='';
					  }
					  function dis2()
					  {
					  	document.addcat.QPack.disabled='';
						document.addcat.QPrice.disabled='';
						document.addcat.Price.disabled='disabled=';
					  }
					  </script>";
switch ($_GET['action'])
{
	case "AddCat":
		switch ($_GET['step'])
		{
			case "1":
				echo "<form action='mater.php' method='get' name='addcat' id='addcat'>
		  <div align='left'>
		    <input name='action' type='hidden' id='action' value='AddCat' />
		    <input name='step' type='hidden' id='step' value='2' />
		    Название категории :
		    <input name='naim' type='text' id='naim' value='' size='50' />
            <br />
		    <input type='submit' name='Submit' value='Добавить' />
		  </div>
		</form>";
				//include("footer.php");
				exit;
			break;
			case "2":
				$query = "INSERT INTO `mater` (`id`,`naim`,`Cat`)
VALUES (NULL,'".$_GET['naim']."','1')";
				////////echo $query."<br />";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				ret('mater.php');
			break;
		}
	break;
	case "AddMat":
		switch ($_GET['step'])
		{
			case"1":
				echo "<form action='mater.php' method='get' name='addcat' id='addcat'>
				  <div align='left'>
					  <input name='action' type='hidden' id='action' value='AddMat' />
					  <input name='step' type='hidden' id='step' value='2' />
					  <input name='UpId' type='hidden' id='step' value='".$_GET['UpId']."' />
					  <br />
					  Название название материала:
					  <input name='naim' type='text' id='naim' value='' size='50' />
					  <br />
					  Еденица измерения";
					 $query = "SELECT * FROM `edizm`";
					//////////echo $query."<br />";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					  echo "<select name='edizm' id='edizm'>";
					 for ($i=0;$i<$count;$i++)
					{
						$row = mysqli_fetch_array($result);
						echo "<option value='".$row['id']."'>".$row['naim']."</option>";
					}
					echo "</select>		      
					  <br />
					 
					  <table width='100%' border='1' cellspacing='0' cellpadding='1'>
  <tr>
    <td><input name='varr' type='radio' value='1' checked='checked' onclick='dis1()'/><br />
	Цена за штуку <input name='Price' type='text'/></td>
    <td><input name='varr' type='radio' value='2' onclick='dis2()'/><br />Количество в упаковке:<input name='QPack' type='text'  disabled='disabled'/><br />
	Стоимость упаковки <input name='QPrice' type='text' disabled='disabled'/></td>
  </tr>
</table>

					  Минимальное количество на местах хранения 
					  <input name='MinOst' type='text' id='MinSk' size='3' maxlength='3' />
					  <br />
					  Примечание
					  <input name='prim' type='text' id='prim' />
					  <br />
					  <input type='submit' name='Submit' value='Добавить' />
					</div>
				</form>";
				//include("footer.php");
				exit;
			break;
			case"2":
			if ($_GET['varr']==1)
			{
				$Price=$_GET['Price'];
				$QPrice=$_GET['Price'];
				$QPack=1;
				
				
			}
			else
			{
				
				$QPrice=$_GET['QPrice'];
				$QPack=$_GET['QPack'];
				$Price=$QPrice/$QPack;
			}
				$query = "INSERT INTO `mater` (`id`, `naim`, `edizm`, `QPack`, `QPrice`, `Price`, `UpId`, `Cat`, `MinOst`, `prim`)
VALUES (NULL, '".$_GET['naim']."', '".$_GET['edizm']."', '".$QPack."', '".$QPrice."','".$Price."', '".$_GET['UpId']."', '0', '".$_GET['MinOst']."', '".$_GET['prim']."')";
				////////echo $query."<br />";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				if (isset($_SESSION['pred']))
				{
					ret($_SESSION['pred']);
				}
				ret('mater.php');
			break;
		}
	break;
	case "del":
		$query = "DELETE FROM `mater` WHERE `id`=".$_GET['id'];
		////////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$query = "DELETE FROM `mater` WHERE `UpId`=".$_GET['id'];
		////////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		ret('mater.php');
	break;
	case "change":
		if (isset($_GET['ch']))
		{
		if ($_GET['varr']==1)
			{
				$Price=$_GET['Price'];
				$QPrice=$_GET['Price'];
				$QPack=1;
				
				
			}
			else
			{
				
				$QPrice=$_GET['QPrice'];
				$QPack=$_GET['QPack'];
				$Price=$QPrice/$QPack;
			}
			$query = "UPDATE `mater`
			SET
			`naim`='".$_GET['naim']."', 
			`edizm`='".$_GET['edizm']."', 
			`QPack`='".$QPack."', 
			`QPrice`='".$QPrice."',
			 `Price`='".$Price."', 
			 `UpId`='".$_GET['UpId']."', 
			 `MinOst`='".$_GET['MinOst']."', 
			 `prim`='".$_GET['prim']."'
			WHERE `id`=".$_GET['id'];
			////////echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			ret('mater.php');
		}
		if (isset($_GET['del']))
		{
			$query = "DELETE FROM `mater` WHERE `id`=".$_GET['id'];
			////////echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			ret('mater.php');
		}
			$query = "SELECT `id`,`naim`, `edizm`, `QPack`, `QPrice`, `Price`, `UpId`, `Cat`, `MinOst`, `prim` FROM `mater` WHERE `id`=".$_GET['id'];
			////////echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			$row = mysqli_fetch_array($result);
			echo "<form action='mater.php' method='get' name='addcat' id='addcat'>
			  <div align='left'>
			  	<input name='id' type='hidden' id='action' value='".$_GET['id']."' />
				  <input name='action' type='hidden' id='action' value='change' />
				  <input name='UpId' type='hidden' id='step' value='".$row['UpId']."' />
				  <input type='hidden' name='var' value='ch' />
				  <br />
				  Название название материала:
				  <input name='naim' type='text' id='naim' value='".$row['naim']."' size='50' />
				  <br />
				  Еденица измерения"; 
				 $query = "SELECT * FROM `edizm`";
					//////////echo $query."<br />";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					  echo "<select name='edizm' id='edizm'>";
					 for ($i=0;$i<$count;$i++)
					{
						$rowA= mysqli_fetch_array($result);
						if ($rowA['id']==$row['edizm']) echo "<option value='".$rowA['id']."' selected='selected'>".$rowA['naim']."</option>";
						else echo "<option value='".$rowA['id']."'>".$rowA['naim']."</option>";
					}
					echo "</select>	";
					if ($row['QPack']==1)
					{
					 echo "<table width='100%' border='1' cellspacing='0' cellpadding='1'>
  <tr>
    <td><input name='varr' type='radio' value='1' checked='checked' onclick='dis1()'/><br />
	Цена за штуку <input name='Price' type='text' value='".$row['Price']."'/></td>
    <td><input name='varr' type='radio' value='2' onclick='dis2()'/><br />Количество в упаковке:<input name='QPack' type='text'  disabled='disabled'/><br />
	Стоимость упаковки <input name='QPrice' type='text' disabled='disabled'/></td>
  </tr>
</table> ";
				}
				else
				{
					 echo "<table width='100%' border='1' cellspacing='0' cellpadding='1'>
  <tr>
    <td><input name='varr' type='radio' value='1'  onclick='dis1()'/><br />
	Цена за штуку <input name='Price' type='text' value='' disabled='disabled'/></td>
    <td><input name='varr' type='radio' value='2' onclick='dis2()' checked='checked' /><br />
	Количество в упаковке:<input name='QPack' type='text' value='".$row['QPack']."' /><br />
	Стоимость упаковки <input name='QPrice' type='text' value='".$row['QPrice']."' /></td>
  </tr>
</table> ";
				}
     
				  echo "<br />
				  Минимальное количество на местах хранения 
				  <input name='MinOst' type='text' id='MinSk' size='3' maxlength='3'  value='".$row['MinOst']."'/>
				  <br />
				  Примечание
				  <input name='prim' type='text' id='prim'  value='".$row['prim']."'/>
				  <br />
				  <input type='submit' name='ch' value='Изменить' />
				  <input type='submit' name='del' value='Удалить материал' />
			  </div>
			</form>";	
				//include("footer.php");
				exit;
			break;
	
}
if (isset($_GET['pred']))
{
	$_SESSION['pred']=$_GET['pred'];
}
$query = "SELECT `mater`.`id`, `mater`.`naim`, `mater`.`UpId`, `mater`.`Cat`
FROM mater
ORDER BY `mater`.`UpId` ASC,`mater`.`naim` ASC";
//////////echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
if ($count>0)
{
	echo "<center><center><a href='mater.php?action=AddCat&step=1' class='menu'>Добавит категорию</a></center>";
	echo "<TABLE BORDER=0 align='left'>";
	$cc=0;
	$cm=0;
	for ($i=0;$i<$count;$i++)
	{
		$row = mysqli_fetch_array($result);
		if ($row['Cat']==1)
		{
			$cc++;
			$cat['$cc][id']=$row['id'];
			$cat['$cc][naim']=$row['naim'];
			
		}
		else
		{
			$cm++;
			$mat['$cm][id']=$row['id'];
			$mat['$cm][naim']=$row['naim'];
			$mat['$cm][UpId']=$row['UpId'];
			
		}
		
	}
	for($i=1;$i<=$cc;$i++)
	{
		echo "<TR><TD>
    <TABLE BORDER=0 align='left'><TR><TD align='left'><A  onClick='Toggle(this)' class='menu'><IMG SRC='image/minus.gif'> ".$cat['$i][naim']."</A><DIV><a href='mater.php?action=del&id=".$cat['$i][id']."&cat=1' class='small2'>Удалить категорию</a>|<a href='mater.php?action=AddMat&UpId=".$cat['$i][id']."&step=1' class='small2'>Добавить материал</a>";

		for($j=1;$j<=$cm;$j++)
		{
		
		if ($cat['$i][id']==$mat['$j][UpId'])
			echo "<TABLE BORDER=0><TR><TD WIDTH=10></TD><TD><IMG SRC='image/leaf.gif'><a href='mater.php?action=change&id=".$mat['$j][id']."' class='small'>". $mat['$j][naim']."</a><DIV>
         </DIV></TD></TR></TABLE>";
		} 
		echo "</DIV></TD></TR></TABLE>
   </TR></TD>";
	}
 
echo "</TABLE>";
}
else
{
	echo "<center><a href='mater.php?action=AddCat&step=1' class='menu'>Добавить категорию</a></center>";
}
//include("footer.php");
?>