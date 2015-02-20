<?php
add_action('admin_menu', 'soundhouse_featured_menu');

function soundhouse_featured_menu() {
	add_menu_page( 'Featured Artists', 'Featured Artists', 'manage_options', 'manage_featured_artists' , 'manage_featured_artists_callback' );
}
add_action('admin_head' , 'add_css');
function add_css(){ ?>
<style>
.pagination1 ul li {
    display: inline;
    margin: 0 10px;
}
</style>
<?php }

if(!isset($_GET['action']) && empty($_GET['action'])) {
function manage_featured_artists_callback() {

////////////////////////////////////////////////////////////////////////
global $wpdb;
$featured_artist = $wpdb->prefix."featured_artist";
$qry = "select * from $featured_artist WHERE   DATEDIFF(NOW(), payment_date) <= 7  ";
$sql = mysql_query($qry); 
$total = mysql_num_rows($sql);
 
$adjacents = 3;
$targetpage = "admin.php?page=manage_featured_artists"; //your file name
$limit = 10; //how many items to show per page
$page = $_GET['pg'];

if($page){ 
$start = ($page - 1) * $limit; //first item to display on this page
}else{
$start = 0;
}

/* Setup page vars for display. */
if ($page == 0) $page = 1; //if no page var is given, default to 1.
$prev = $page - 1; //previous page is current page - 1
$next = $page + 1; //next page is current page + 1
$lastpage = ceil($total/$limit); //lastpage.
$lpm1 = $lastpage - 1; //last page minus 1

$sql2 = $qry . " limit ".  $start . " , ". $limit ;
$sql_query = mysql_query($sql2); 
$curnm = mysql_num_rows($sql_query);

 
echo '<div class="wrap">
			<h2>Payment Information</h2>
					<table class="wp-list-table widefat fixed posts">
					<thead>
					<tr> <th>Sr no </th> <th> Name</th>    
					<th> Transaction Date</th> 
					<th>Status</th>
					<th> Edit</th>
			</tr></thead>';
 $i=1;
 $x=1;
 while ($row = mysql_fetch_array($sql_query)){
	$class= ($x==1 ) ? " class='alternate' " : "";
	 
	echo '<tr '.$class.'>';
	echo '<td>' .$i.'</td>';
	echo '<td>'. $row['first_name'].'</td>';
	echo '<td>'.$row['payment_date'].'</td>';
	echo '<td>';
	if( $row['featured_artist_status']=='0' ){
		echo 'Inactive';
		}else { echo 'Active';}
	echo '</td>';
	echo '<td> ';
	echo '<a href="?page=manage_featured_artists&action=edit&uid='.$row['user_id'].'">Edit </a></td>';
	echo '</tr>';
	$i++; 
	$x=1-$x;
	} 
echo '</table>';

 echo '</div>';
///////////////////////////////////////////////////////
/* CREATE THE PAGINATION */

$pagination = "";
if($lastpage > 1)
{ 
$pagination .= "<div class='pagination1'> <ul>";
if ($page > $counter+1) {
$pagination.= "<li><a href=\"$targetpage&pg=$prev\">prev</a></li>"; 
}

if ($lastpage < 7 + ($adjacents * 2)) 
{ 
for ($counter = 1; $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li><span class='active'>$counter</span></li>";
else
$pagination.= "<li><a href=\"$targetpage&pg=$counter\">$counter</a></li>"; 
}
}
elseif($lastpage > 5 + ($adjacents * 2)) //enough pages to hide some
{
//close to beginning; only hide later pages
if($page < 1 + ($adjacents * 2)) 
{
for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
{
if ($counter == $page)
$pagination.= "<li><span class='active'>$counter</span></li>";
else
$pagination.= "<li><a href=\"$targetpage&pg=$counter\">$counter</a></li>"; 
}
$pagination.= "<li>...</li>";
$pagination.= "<li><a href=\"$targetpage&pg=$lpm1\">$lpm1</a></li>";
$pagination.= "<li><a href=\"$targetpage&pg=$lastpage\">$lastpage</a></li>"; 
}
//in middle; hide some front and some back
elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
{
$pagination.= "<li><a href=\"$targetpage&pg=1\">1</a></li>";
$pagination.= "<li><a href=\"$targetpage&pg=2\">2</a></li>";
$pagination.= "<li>...</li>";
for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
{
if ($counter == $page)
$pagination.= "<li><span class='active'>$counter</span></li>";
else
$pagination.= "<li><a href=\"$targetpage&pg=$counter\">$counter</a></li>"; 
}
$pagination.= "<li>...</li>";
$pagination.= "<li><a href=\"$targetpage&pg=$lpm1\">$lpm1</a></li>";
$pagination.= "<li><a href=\"$targetpage&pg=$lastpage\">$lastpage</a></li>"; 
}
//close to end; only hide early pages
else
{
$pagination.= "<li><a href=\"$targetpage&pg=1\">1</a></li>";
$pagination.= "<li><a href=\"$targetpage&pg=2\">2</a></li>";
$pagination.= "<li>...</li>";
for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; 
$counter++)
{
if ($counter == $page)
$pagination.= "<li><span class='active'>$counter</span></li>";
else
$pagination.= "<li><a href=\"$targetpage&pg=$counter\">$counter</a></li>"; 
}
}
}

//next button
if ($page < $counter - 1) 
$pagination.= "<li><a href=\"$targetpage&pg=$next\">next</a></li>";
else
$pagination.= "";
$pagination.= "</ul></div>\n"; 
}
echo $pagination;
///////////////////////////////////////////////////////
}
 
 }else {
	function manage_featured_artists_callback(){
	global $wpdb;
	if(isset($_REQUEST['uid']))
	{ $uid=$_REQUEST['uid']; }

	$featured_artist = $wpdb->prefix."featured_artist";
	$qry = "select * from $featured_artist WHERE 
                user_id='$uid'" ;
	$user_info = $wpdb->get_results($qry);
	//echo'<pre>';print_r($user_info); echo'</pre>'; 
	if(isset($_REQUEST['change_status'])){
			if(isset($_POST['no']) )
			{
			$data_array=array('featured_artist_status'=>'0');
			$where=array('user_id' => $uid);
			$wpdb->update( $featured_artist, $data_array, $where );
				}else { $data_array=array('featured_artist_status'=>'1');
			$where=array('user_id' => $uid);
			$wpdb->update( $featured_artist, $data_array, $where );}
		}
	?>
	
	<div class="wrap">
	<h1>Artist Detail</h1>
	<table class="form-table">
	<form name="" action="" method="post">
<tbody>
<?php foreach($user_info as $user) { ?>
<tr>
<th scope="row"><label for="blogname">First Name</label></th>
<td> <?php echo $user->first_name;  ?></td>
</tr>
<tr>
<th scope="row"><label for="blogname">Last Name</label></th>
<td> <?php echo $user->last_name;  ?></td>
</tr>
<tr>
<th scope="row"><label for="blogname">Address</label></th>
<td> <?php echo $user->address;  ?></td>
</tr>
<tr>
<th scope="row"><label for="blogname">City</label></th>
<td> <?php echo $user->city;  ?></td>
</tr>
<tr>
<th scope="row"><label for="blogname">State</label></th>
<td> <?php echo $user->state;  ?></td>
</tr>

<tr>
<th scope="row"><label for="blogname">Payment Date</label></th>
<td> <?php echo $user->payment_date;  ?></td>
</tr>
<tr>
<th scope="row"><label for="blogname">Hide Artist</label></th>
<td> <input type="checkbox" value="0" name="no"></td>
</tr>
<tr>
<th scope="row"><label for="blogname"</label></th>
<td> <input type="submit" value="Save Changes" class="button button-primary" name="change_status" ></td>
</tr>
 <?php }  ?>
 </form>
</table> 

   </div>
<?php }
	}

