<?php 
    function getMaterialsList() {
    $query = "select * from material ";

    return executeQuery($query);        
    }

?>

<h1><?php echo($projectName); ?></h1>
    
<h3>Manage Materials</h3>
<form method="post" action="addMaterial.php">
    Material: 
    <select name="materialId">
        <?php foreach(getMaterialsList() as $material) {
            extract($material);
            var_dump($material);
            echo "<option value='$materialUnitId'>$name</option>";
        }?>
    </select><br/>
    
    Material Cost: <input type="text" name="cost" value="<?php echo($cost);?>"/><br/>
    Material Quantity: <input type="text" name="quantity" value="<?php echo($quantity);?>"/><br/>
    <input type="hidden" name="projectId" value="<?php echo($projectId);?>"/>
    <input type="submit" value="Add Material"/>
</form>
<hr/>

<h3>Current Materials List</h3>
<form method="post" action="addLabor.php">
    Labor Hours: <input type="text" name="hours" value="<?php echo($hours);?>"/><br/>
    Labor Rate: <input type="text" name="rate" value="<?php echo($rate);?>"/><br/>
    <input type="hidden" name="projectId" value="<?php echo($projectId);?>"/>
    <input type="submit" value="Add Labor"/>
</form>
<hr/>

<form method="post" action="calculateTotals.php">
    <input type="hidden" name="projectId" value="<?php echo($projectId);?>"/>
    <input type="submit" value="Calculate Project Totals"/>
</form>

</form>
