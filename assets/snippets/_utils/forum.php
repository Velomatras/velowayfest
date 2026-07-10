<?php 

class Forum{
	private $mysqli = NULL;
	private $fullname = NULL;
	private $nameUser = NULL;
	private $forum_categories = NULL;
	private $forum_topics = NULL;
	private $forum_posts = NULL;
	private $userId = NULL;
	
	
	public function __construct($mysqli, $nameUser, $fullname, $forum_categories, $forum_topics, $forum_posts, $userId) {
$this->mysqli = $mysqli;	
	
$this->nameUser = $nameUser;	
$this->fullname = $fullname;

$this->forum_categories = $forum_categories;
$this->forum_topics = $forum_topics;
$this->forum_posts = $forum_posts;
$this->userId = $userId;
        
    }
	
    //Получить массив категорий данного форума со всеми атрибутами	
	public function categories() {
		$nameUser = $this->nameUser;
		$fullname = $this->fullname;
		$q = "SELECT cat_id, cat_name, cat_description, $nameUser.username, $fullname.fullname
FROM $this->forum_categories
JOIN $this->nameUser ON $this->nameUser.id = $this->forum_categories.cat_id
     JOIN $this->fullname ON $this->fullname.id = $this->forum_categories.cat_id ";
$result = $this->mysqli->query("$q");


	//	$result = $this->mysqli->query("SELECT cat_id, cat_name, cat_description, $this->nameUser.username, $this->fullname.fullname
//FROM $this->forum_categories
//JOIN $this->nameUser ON $this->nameUser.id = $this->forum_categories.cat_id
//     JOIN $this->fullname ON $this->fullname.id = $this->forum_categories.cat_id ");
	 //ORDER BY `cat_id`
	 
	 if (!empty($result)){
	 while($row = $result->fetch_array(MYSQLI_ASSOC)){
		 $forum_cat[] = array(
		 'cat_id' => $row['cat_id'],
		 'cat_name' => $row['cat_name'],
		 'cat_description' => $row['cat_description'],
		 'username' => $row['username'],
		 'fullname' => $row['fullname']
		 );
		 	 }
			 return $forum_cat;
	}
	else return 0;
	}

   //Получить массив тем данной категории со всеми атрибутами
	public function topics() {
		
		$q = ("SELECT topic_id, topic_subject, topic_description, topic_date, topic_date_mod, topic_cat, topic_by, zakrep, zamok, stop,
		$this->nameUser.username, $this->fullname.fullname
FROM $this->forum_topics
JOIN $this->nameUser ON $this->nameUser.id = $this->forum_topics.topic_by
     JOIN $this->fullname ON $this->fullname.id = $this->forum_topics.topic_by ORDER BY topic_date");
	$result = $this->mysqli->query($q);
	 
	 //ORDER BY `cat_id`
	 if (!empty($result)){
	 while($row = $result->fetch_array(MYSQLI_ASSOC)){
		 $forum_topic[] = array(
		 'topic_id' => $row['topic_id'],
		 'topic_subject' => $row['topic_subject'],
		 'topic_description' => $row['topic_description'],
		 'topic_date' => $row['topic_date'],
		 'topic_date_mod' => $row['topic_date_mod'],
		 'topic_cat' => $row['topic_cat'],
		 'topic_by' => $row['topic_by'],
		 'username' => $row['username'],
		 'zakrep' => $row['zakrep'],
		 'zamok' => $row['zamok'],
		 'stop' => $row['stop']
		 );
		 	 }
			 	 
			 return $forum_topic;
	}
 else return 0;	
	}
	
	//Получение атрибутов топика
	public function topic_Attributs($post_topic){
		
		$q = ("SELECT topic_id, zakrep, zamok, stop,
		$this->nameUser.username, $this->fullname.fullname
FROM $this->forum_topics
JOIN $this->nameUser ON $this->nameUser.id = $this->forum_topics.topic_by
     JOIN $this->fullname ON $this->fullname.id = $this->forum_topics.topic_by WHERE topic_id=$post_topic");
	$result = $this->mysqli->query($q);
	
	 if (!empty($result)){
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		
		$forum_topic[] = array(
		'zakrep' => $row['zakrep'],
		 'zamok' => $row['zamok'],
		 'stop' => $row['stop']
		);
		
	}
	return $forum_topic;
	}
	else return 0;
	}
	
	//Получить массив постов данной темы со всеми атрибутами
	 public function posts($topic) {
		$q = ("SELECT post_id, post_content, post_date, post_date_mod, post_topic, post_by,
		$this->nameUser.username, $this->fullname.fullname
FROM $this->forum_posts
JOIN $this->nameUser ON $this->nameUser.id = $this->forum_posts.post_by
     JOIN $this->fullname ON $this->fullname.id = $this->forum_posts.post_by WHERE post_topic = $topic");
	   //
	   $result = $this->mysqli->query($q);
	 
	   if (!empty($result)){
	   while($row = $result->fetch_array(MYSQLI_ASSOC)){
		 $forum_post[] = array(
		 'post_id' => $row['post_id'],
		 'post_content' => $row['post_content'],
		 'post_date' => $row['post_date'],
		 'post_date_mod' => $row['post_date_mod'],
		 'post_topic' => $row['post_topic'],
		 'post_by' => $row['post_by'],
		 'username' => $row['username'],
		 'fullname' => $row['fullname']
		 );
		 	 }
			 return $forum_post;
	   }
	 else return 0;
	 }
	 
	 //Возвращает 1 если юзер отписался в данной теме
	 public function posts_Attributs($topic, $userId){
		 $galka = 0;
		 $result = $this->mysqli->query("SELECT post_by, $this->nameUser.username FROM $this->forum_posts
JOIN $this->nameUser ON $this->nameUser.id = $this->forum_posts.post_by
			WHERE post_topic = $topic ");
			if (!empty($result)){
		 while($row = $result->fetch_array(MYSQLI_ASSOC)){
			 $post_by = $row['post_by'];
			if ($post_by == $userId) {
			$galka = 1;
            //break;			
			}
					 }
			}
		 return $galka;
	 }
	 
	 //Получить автора последнего поста данного топика и дату
	 public function ppost($topic_id){
		//$posts = $this->posts($topic_id);
		 //$this->sortRates($posts);
		//$post_Date = $posts['post_date'][0];
		//$post_Name = $posts['post_by'][0];
	 $result2 = $this->mysqli->query("SELECT post_date, post_by, $this->nameUser.username FROM $this->forum_posts
JOIN $this->nameUser ON $this->nameUser.id = $this->forum_posts.post_by
			WHERE post_topic = $topic_id ORDER BY post_date");
			$con = 0;
			$datePP = null;
			$namePP = null;
			while($row = $result2->fetch_array(MYSQLI_ASSOC)){
				$con++;
					$datePP = $row['post_date'];
				    $namePP = $row['username'];
					 				
			}
			$info = array($namePP, $datePP, $con);
		return $info;
	 }
	 
	function sortRates(&$rates) {
            
            function sort_func($a, $b)
{
    if ($a['post_date'] == $b['post_date']) {
        return 0;
    }
    else return ($a['post_date'] < $b['post_date']) ? -1 : 1;
}
           

            usort($rates, sort_func);
			return $rates;
        }
		
		
	function sortTopic(&$rates) {
         		 function sort_topic($a, $b){
    if ($a['zakrep'] == $b['zakrep']) {
		
		if ($a['datePP'] == $b['datePP']) return 0;
					else return ($a['datePP'] < $b['datePP']) ? 1 : -1;
            }
    else return ($a['zakrep'] > $b['zakrep']) ? -1 : 1;
} 		  
usort($rates, "sort_topic");
        return $rates;    
        }
		
	
		
		
		public function getUserId(){
			$id = $this->userId;
			return $id;
		}

 public function countReport(){
 $query = "SELECT ownerid, count(*) AS cnt2
FROM way_library
  WHERE way_library.ownerid = $userId"; 	 
 }
 
 public function print_new_topic($cat, $topic, $name_cat, $name_topic, $modx){
	echo "<span class=\"stroke\"><b><a href=\"[~[*id*]~]\">Форум</a></b>&ensp;-><b>
  <a  href=\"[~[*id*]~]?cat=$cat\">$name_cat</a></b></span>&ensp;->
  <b>$name_topic</b><br><br>";	
  echo "<h2>Создать новую тему</h2><br>";
  echo "<form action=\"[~[*id*]~]?cat=$cat\" method=\"POST\" name=\"my3\" enctype=\"multipart/form-data\">";
  echo "<h3>Заголовок: (обязательно)</h3><br>";
  echo "<p><input size=\"50\" id=\"topic_name\" class=\"typeInput\" name=\"topic_name\" type=\"text\" maxlength=\"45\" autofocus></input></p><br><br>";
  echo "<h3>Краткое описание:</h3><br>";
  echo "<input size=\"50\" class=\"typeInput\" id=\"topic_description\" name=\"topic_description\" type=\"text\" maxlength=\"60\"></input><br><br>";
  echo "<table>";
   echo $modx->getChunk('html_redaktor');
			?>
			
			{{html_redaktor}}
			<?php
echo "</table>";
   echo "<h3>Описание: (обязательно)</h3><br>";
  echo "<textarea cols=\"120\" rows=\"30\" id=\"topic_new\" name=\"topic_new\" ></textarea>";
  echo "<p><input size=\"10\" id=\"newtopic\" class=\"buttons\" name=\"newtopic\" type=\"submit\"
		value=\"Опубликовать\" onclick=\"clickNewTopic()\" /></p>";
  echo "</form>";
  ?>
  <script type="text/javascript">
  	
  
var editor = new wysihtml5.Editor("topic_new", { // id текстовой области
  toolbar:      "wysihtml5-toolbar", // id тулбара
  stylesheets: ["http://veloway.su/assets/plugins/wysihtml5-0.3.0/website/css/editor.css", 
  "http://yui.yahooapis.com/2.9.0/build/reset/reset-min.css"],
  parserRules:  wysihtml5ParserRules // включает анализатор правил
});
</script>
 <?php 
}

 public function newTopic ($cat, $commentY, $topic_name, $topic_description){
	 $date = time();
	 
	
	if (!empty($commentY) && !empty($topic_name) && !empty($topic_description)){
	date_default_timezone_set('Europe/Moscow');
	$date1 = date('Y-m-d H:i:s', $date);
	
	//$stmt4 = $this->mysqli->prepare("INSERT INTO $this->forum_topics (topic_subject, topic_description, topic_date, topic_cat, topic_by)
	// VALUES (?, ?, ?, ?, ?)");
	 $stmt4 = $this->mysqli->prepare("INSERT INTO $this->forum_topics (topic_subject, topic_description, topic_by, topic_cat)
	 VALUES (?, ?, ?, ?)");
 $stmt4->bind_param("ssii", $topic_name, $topic_description, $this->userId, $cat);
//$stmt4->bind_param("sssii", $topic_name, $topic_description, $date1, $cat, $this->userId);
 // "is" означает, что $id связывается, как целое число, а $label - как строка
$stmt4->execute();

?>
 <script type="text/javascript">
 alert ( document.my3.topic_name.value );
 alert ( document.my3.topic_description.value );
 alert ( document.my3.topic_new.value );
 }
</script>
 <?php 
   $url = (isset($_SERVER["HTTPS"]) && ($_SERVER["HTTPS"] == "on")) ? "https" : "http";
$url .= "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ;
header("Location: {$url}");

 }
 }
  
	}
		



	?>