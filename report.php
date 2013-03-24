<?php
require_once 'header.php'; 

$userId = getCurrentUserId();

    $query = <<<STR
select name
    , p.projectId
    , pl.laborCost
    , pm.materialCost
    , pm.numMaterials
    , pl.numTasks
from project p
 left join (select projectId, count(projectLaborItemId) numTasks, sum(CostPerHour * Hours) as laborCost from projectLaborItem group by projectId) pl on p.projectId = pl.projectId
 left join (select projectId, count(materialId) numMaterials, sum(cost * number) as materialCost from projectMaterial group by projectId) pm on p.projectId = pm.projectId
where p.id = $userId
order by lower(p.name)
STR;

    $projects = executeQuery($query);
?>

<h4><br>User Projects Report</h4>

<table class='report'>
    <thead>
    <tr>
        <th>Project Name</th>
        <th>Qty. Materials</th>
        <th>Material Cost</th>        
        <th>Qty. Tasks</th>
        <th>Labor Cost</th>
        <th>Total Cost</th>
    </tr>
    <thead>
    <tbody>

<?php
$numberOfProjects = 0;
foreach ($projects as $project)
    {
        extract($project);
    $totalCostOfProjects += $materialCost + $laborCost;
    $projectCost = money_format($materialCost + $laborCost);
    $laborCost = money_format($laborCost);
    $materialCost = money_format($materialCost);   
    $numberOfProjects++;
        $output .= <<<ABC
        <tr>
            <td>$name</td>
            <td class="numberColumn">$numMaterials</td>
            <td class="numberColumn">$materialCost</td>
            <td class="numberColumn">$numTasks</td>
            <td class="numberColumn">$laborCost</td>
            <td class="numberColumn">$projectCost</td>
        </tr>

ABC;
    }

    echo($output);
?>
    <tbody>
    <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="border-top: solid 2px black !important;">Total:</td>
            <td  style="border-top: solid 2px black !important;"><?php echo money_format($totalCostOfProjects) ?></td>
        </tr>
<?php if($numberOfProjects != 0) {?>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>Avg. Project Cost:</td>
            <td><?php echo money_format($totalCostOfProjects/$numberOfProjects) ?></td>
        </tr>
<?php } ?>
        
    </tfoot>
    
</table>

<p class="contentClear">Return to the <a href="home.php">Projects Page</a></p>

<?php
require_once 'footer.php'; 
?>