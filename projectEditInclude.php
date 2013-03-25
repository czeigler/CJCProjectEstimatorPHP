<?php 
    function getMaterialsList() {
    $query = "select * from material ";

    return executeQuery($query);        
    }

?>

<h1><?php echo($projectName); ?></h1>

    <?php
$hasMaterials = false;
$hasLabor = false;
    if(! empty($errorMessages)) {
        echo('<ul class="errorMessage">');
        echo($errorMessages); 
        echo('</ul><br/>');
    }
    ?>
<div class="content"><h4>Estimate Management Dashboard</h4>
    
   
    <div class="dashboard2">
<div class="legend">Manage Labor</div>
<form method="post" action="addLabor.php">
    Description: <input type="text" name="laborDescription" maxlength="20" value="<?php echo($laborDescription);?>"/><br/>
    Labor Hours: <input type="text" name="hours" maxlength="4" value="<?php echo($laborHours);?>"/><br/>
    Labor Rate: <input type="text" name="rate" maxlength="4" value="<?php echo($laborRate);?>"/><br/>
    <input type="hidden" name="id" value="<?php echo($projectId);?>"/>
    <input type="submit" class="input" value="Add Labor"/>
</form>
<p />
<div class="dashboardTable">Current Labor Line Items

<form id="removeLabor" method="post" action="removeLabor.php">
<?php
    $conn = dbConnect();

    $stmt = $conn->prepare('select * from projectLaborItem pl where pl.projectId = :id');
    $stmt->bindParam(':id', $projectId);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);  //retreive the rows as an associative array

    dbDisconnect($conn);

    //var_dump($results);
    
    // materials display  
    echo "<table class='projectItems'>";
    echo "<tr><th></th><th>Description</th><th>Rate</th><th>Hours</th><th>Cost</th></tr>";
    foreach ($results as $projectLaborItem)
    {
        $hasLabor = true;
        echo "<tr>";
        echo "<td><a class='removeLabor'>[Remove]</a><input type='hidden' class='removeId' value='" . $projectLaborItem['ProjectLaborItemId'] . "'/></td>";
        echo "<td>" . $projectLaborItem['Description'] . "</td>";
        echo "<td class='numberColumn'>" . money_format(floatval($projectLaborItem['CostPerHour'])) . "</td>";
        echo "<td class='numberColumn'>" . floatval($projectLaborItem['Hours']) . "</td>";
        echo "<td class='numberColumn'>" . money_format(floatval($projectLaborItem['CostPerHour'] * $projectLaborItem['Hours'])) . "</td>";      

        echo "</tr>";
        $totalLabor += floatval($projectLaborItem['CostPerHour'] * $projectLaborItem['Hours']);
    }
    echo "</table>";
?></div>
    <input type="hidden" name="id" value="<?php echo($projectId);?>"/>
    <input type="hidden" id="projectLaborItemId" name="projectLaborItemId" value=""/>
</form>
</div>
    
    
    
    <div class="dashboard2">
<div class="legend">Manage Materials</div>
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
    
    Material Cost: <input type="text" name="cost"  maxlength="4" value="<?php echo($materialCost);?>"/><br/>
    Material Quantity: <input type="text" name="quantity"  maxlength="4" value="<?php echo($materialQuantity);?>"/><br/>
    <input type="hidden" name="id" value="<?php echo($projectId);?>"/>
    <input type="submit" class="input" value="Add Material"/>
</form>
<p />
<div class="dashboardTable">Current Materials List

<form id="removeMaterial" method="post" action="removeMaterial.php">
<?php
    $conn = dbConnect();

    $stmt = $conn->prepare('select pm.materialId, m.description, pm.cost, pm.number, mu.name from projectMaterial pm join material m on pm.materialId = m.materialId join materialUnit mu on m.materialUnitId = mu.materialUnitId where pm.projectId = :id');
    $stmt->bindParam(':id', $projectId);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);  //retreive the rows as an associative array

    dbDisconnect($conn);

//    var_dump($results);
    
    // materials display
    echo "<table class='projectItems'>";
    echo "<tr><th></th><th>Material</th><th>Cost</th><th colspan='2'>Qty</th><th>Cost</th></tr>";
    foreach ($results as $projectMaterial)
    {
        $hasMaterials = true;
        echo "<tr>";
        echo "<td><a class='removeMaterial'>[Remove]</a><input type='hidden' class='removeId' value='" . $projectMaterial['materialId'] . "'/></td>";
        echo "<td>" . $projectMaterial['description'] . "</td>";
        echo "<td class='numberColumn'>" . money_format(floatval($projectMaterial['cost'])) . "</td>";
        echo "<td class='numberColumn'>" . number_format($projectMaterial['number'], $decimals) . "</td>";
        echo "<td class='unitsColumn'>" . $projectMaterial['name'] . "</td>";
        echo "<td class='numberColumn'>" . money_format(floatval($projectMaterial['cost'] * $projectMaterial['number'])) . "</td>";      

        echo "</tr>";
        $totalMaterials += floatval($projectMaterial['cost'] * $projectMaterial['number']);
                
    }
    echo "</table>";
?></div>
    <input type="hidden" name="id" value="<?php echo($projectId);?>"/>
    <input type="hidden" id="materialId" name="materialId" value=""/>
</form>
</div>
<div class="dashboardCosts">
<div class="legend">Project Totals</div>

<div class="dashboardTable"><table class="projectItems">
<?php
echo "<tr><td>Total Labor:</td><td class='numberColumn'>" . money_format($totalLabor) . "</td></tr>";
echo "<tr><td>Total Materials:</td><td class='numberColumn'>" . money_format($totalMaterials) . "</td></tr>";
$grandTotal = $totalLabor + $totalMaterials;
echo "<tr><td>Grand Total:</td><td class='numberColumn'>" . money_format($grandTotal) . "</td></tr>";
?>
</table>
</div></div>

    
    
    
    
    <p class="contentClear">Return to the <a href="home.php">Projects Page</a></P>
</div>

    <?php
    if(! $hasMaterials || ! $hasLabor) {
        echo('<ul class="errorMessage">');
        echo("You must have at least on labor item and one material for your project to be complete."); 
        echo('</ul><br/>');
    }
    ?>

<script>
    $(document).ready(function() {
        $('.removeLabor').click(function() {
            if(confirm("Are you sure you want to delete this Labor Item?")) {
                $('#projectLaborItemId').val($(this).next('.removeId').val());
                $('#removeLabor').submit();
            }
        });
    
    $('.removeMaterial').click(function() {
            if (confirm("Are you sure you want to delete this Material?")) {
                $('#materialId').val($(this).next('.removeId').val());
                $('#removeMaterial').submit();
            }

        });
    });
</script>