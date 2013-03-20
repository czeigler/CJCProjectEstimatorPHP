<?php 
    function getMaterialsList() {
    $query = "select * from material ";

    return executeQuery($query);        
    }

?>

<h1><?php echo($projectName); ?></h1>


    <?php
    if(! empty($errorMessages)) {
        echo('<ul class="errorMessage">');
        echo($errorMessages); 
        echo('</ul><br/>');
    }
    ?>

<h3>Manage Materials</h3>
<form method="post" action="addMaterial.php">
    Material: 
    <select name="materialId">
        <option value="">Please Select a Material</option>
        <?php foreach(getMaterialsList() as $material) {
            if(! is_null($materialId) && $materialId == $material['materialId']) {
                echo "<option value='" . $material['materialId'] . "' selected='true'>" . $material['name'] . "</option>";
            } else {
                echo "<option value='" . $material['materialId'] . "'>" . $material['name'] . "</option>";
            }
        }?>
    </select><br/>
    
    Material Cost: <input type="text" name="cost" value="<?php echo($materialCost);?>"/><br/>
    Material Quantity: <input type="text" name="quantity" value="<?php echo($materialQuantity);?>"/><br/>
    <input type="hidden" name="id" value="<?php echo($projectId);?>"/>
    <input type="submit" value="Add Material"/>
</form>
<hr/>

<h3>Manage Labor</h3>
<form method="post" action="addLabor.php">
    Description: <input type="text" name="laborDescription" value="<?php echo($laborDescription);?>"/><br/>
    Labor Hours: <input type="text" name="hours" value="<?php echo($laborHours);?>"/><br/>
    Labor Rate: <input type="text" name="rate" value="<?php echo($laborRate);?>"/><br/>
    <input type="hidden" name="id" value="<?php echo($projectId);?>"/>
    <input type="submit" value="Add Labor"/>
</form>
<hr/>

<h3>Current Materials List</h3>



<form method="post" action="calculateTotals.php">
    <input type="hidden" name="id" value="<?php echo($projectId);?>"/>
    <input type="submit" value="Calculate Project Totals"/>
</form>

</form>
