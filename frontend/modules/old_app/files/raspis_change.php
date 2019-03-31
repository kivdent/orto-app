<?php 
$ThisVU="all";
$this->title="Выбирите врача"; 
//include("header.php");
echo "<form action='raspis_change_form.php' method='post'>
Врач 
<select name='vrach'>";
$query = "select id,surname,name,otch from `sotr` WHERE (dolzh=1) ORDER BY dolzh ASC" ;
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
for ($i=0; $i <$count; $i++)
{
$row = mysqli_fetch_array($result);
echo "<option value='".$row['id']."'>".$row['surname']." ".$row['name']." ".$row['otch']."</option>"; 
}
echo "</select>
<br>
<input name='ok' type='submit' value='Дальше>>'/>
</form>";
//include("footer.php");
?>