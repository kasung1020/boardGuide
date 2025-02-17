<?php
$host = "127.0.0.1";
$user = "root";
$pw = "";

$dbcon = mysqli_connect($host, $user, $pw);

$sql = "create database bdguide";
$result = mysqli_query($dbcon, $sql);
if ($result)
    echo "데이터베이스 생성 완료<br>";
else
    echo "데이터베이스 생성 실패<br>";

$db_select = mysqli_select_db($dbcon, "bdguide");

$sql = "CREATE TABLE article(
    `article_id` int NOT NULL AUTO_INCREMENT,
    `user_id` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `post_type_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `post_time` datetime NOT NULL,
    `post_edited` datetime NOT NULL DEFAULT (0),
    `reported` int NOT NULL DEFAULT '0',
    `image_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    PRIMARY KEY (`article_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
$result = mysqli_query($dbcon, $sql);
if ($result)
    echo "article 테이블 생성 완료<br>";
else
    echo "article 테이블 생성 실패<br>";

$sql = "CREATE TABLE `article_category` (
    `post_type_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `post_type` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    PRIMARY KEY (`post_type_id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
$result = mysqli_query($dbcon, $sql);
if ($result)
    echo "article_category 테이블 생성 완료<br>";
else
    echo "article_category 테이블 생성 실패<br>";

$sql = "INSERT INTO `article_category` (`post_type_id`, `post_type`) VALUES
('cat_1', '팁과 노하우'),
('cat_10', '추리'),
('cat_2', '협력'),
('cat_3', '경쟁'),
('cat_4', '카드 게임'),
('cat_5', '경제'),
('cat_6', '마피아'),
('cat_7', '블러핑'),
('cat_8', '추상 전략'),
('cat_9', '방탈출')";
$result = mysqli_query($dbcon, $sql);
if ($result)
    echo "article_category 테이블 데이터 입력 완료<br>";
else
    echo "article_category 테이블 데이터 입력 실패<br>";

$sql = "CREATE TABLE `article_comments` (
  `comment_id` int NOT NULL AUTO_INCREMENT,
  `article` int DEFAULT NULL,
  `writer` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `writed_date` datetime DEFAULT (now()),
  `reported` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_id`),
  KEY `FK_article_comments_article` (`article`),
  CONSTRAINT `FK_article_comments_article` FOREIGN KEY (`article`) REFERENCES `article` (`article_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
$result = mysqli_query($dbcon, $sql);
if ($result)
    echo "article_comments 테이블 생성 완료<br>";
else
    echo "article_comments 테이블 생성 실패<br>";

$sql = "CREATE TABLE `article_liked` (
    `article_id` int DEFAULT NULL,
    `liked_user` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    KEY `FK_article_liked_article` (`article_id`),
    CONSTRAINT `FK_article_liked_article` FOREIGN KEY (`article_id`) REFERENCES `article` (`article_id`) ON DELETE CASCADE ON UPDATE CASCADE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
$result = mysqli_query($dbcon, $sql);
if ($result)
    echo "article_liked 테이블 생성 완료<br>";
else
    echo "article_liked 테이블 생성 실패<br>";

$sql = "CREATE TABLE `article_watched` (
    `article_id` int DEFAULT NULL,
    `watched_user` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `watched_ip` char(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    KEY `FK_article_watched_article` (`article_id`),
    CONSTRAINT `FK_article_watched_article` FOREIGN KEY (`article_id`) REFERENCES `article` (`article_id`) ON DELETE CASCADE ON UPDATE CASCADE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
$result = mysqli_query($dbcon, $sql);
if ($result)
    echo "article_watched 테이블 생성 완료<br>";
else
    echo "article_watched 테이블 생성 실패<br>";

$sql = "CREATE TABLE `games` (
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `english_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `released` date DEFAULT NULL,
    `difficulty` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `players_min` int DEFAULT NULL,
    `players_max` int DEFAULT NULL,
    `playtime` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `tip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `rules` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    `likes` int DEFAULT '0',
    `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `category` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `user_id` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE
  ) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
$result = mysqli_query($dbcon, $sql);
if ($result)
    echo "games 테이블 생성 완료<br>";
else
    echo "games 테이블 생성 실패<br>";

$sql = "INSERT INTO `games` (`id`, `name`, `english_name`, `released`, `difficulty`, `players_min`, `players_max`, `playtime`, `tip`, `rules`, `likes`, `image`, `category`, `user_id`) VALUES
(1, '다빈치 코드', 'Da Vinci Code', '2003-11-07', 'Normal', 2, 4, '15분 이내', '\"다빈치 코드\"에서 승리하려면 상대방의 미션과 미션 카드를 주의 깊게 관찰하고, 적극적으로 정보를 교환하며 협력하는 것이 중요합니다.', '모든 블록을 뒤집어 섞어둔 후 2/3인 플레이는 4개, 4인 플레이는 3개의 패를 가져간다. 시작패에는 조커가 있으면 안 된다. 단, 다른 플레이어들과 상의하여 시작패에 넣을 수 있도록 규칙을 변형할 수 있다. 조커를 집은 사람은 조커를 돌려놓고 다른 패를 뽑은 후 다시 잘 섞어둔다. 자신의 패를 규칙대로, 그러나 다른 사람에게 숫자가 보이지 않게 세워둔다. 자신을 기준으로 왼쪽이 작은 수, 오른쪽이 큰 수가 되도록 배열해야 한다. 검은색과 흰색이 같은 숫자일 경우 검은색을 왼쪽에 놓으나, 경우에 따라흰 것을 왼쪽에 두기도 하고 각자 좋을 대로 하기도 한다.', 2, './img/20-1.png', '추리', NULL),
(2, '루미큐브', 'Rummikub', '1978-11-07', 'Normal', 2, 4, '60분', '루미큐브 보드게임을 풀 때, 각 조각의 색과 위치를 주의깊게 관찰하고, 층을 하나씩 완성해 나가며 전략을 짜는 것이 중요합니다.', '룰설명:모든 플레이어는 타일 14개를 가져갑니다선플레이어를 정하고 등록 또는 한개의 타일을 가져갑니다. 등록을 할 때는 내려놓은 세트 숫자를 합쳐서 30이상이어야 합니다.등록을 마친 플레이어는 다음 자신차례에 숫자조합을 진행합니다. 숫자조합은 새로 등록해도 되고 자신이나 상대 플레이어의 타일의 붙여도 됩니다.모든 타일을 내려놓은 사람이 루미큐브를 외치고 게임이 종료됩니다.		 \r\n', 1, './img/20-2.png', '숫자 / 카드게임', NULL),
(3, '딕싯', 'Dixit', '2008-11-07', 'Easy', 3, 8, '30분', '너무 구체적이거나 너무 일반적이지 않은 힌트를 주는 것입니다. 카드를 선택할 때 다른 플레이어들이 카드를 쉽게 맞출 수 없도록 적절한 수준의 추상적인 이야기나 연상을 사용하세요.', 'Dixit 에서는 매 턴마다 한 명의 플레이어가 이야기꾼이 되어 손에 있는 6개의 카드 중 하나를 선택한 다음 해당 카드의 이미지를 기반으로 문장을 구성하고 다른 플레이어에게 카드를 보여주지 않고 큰 소리로 말합니다. 그런 다음 각 플레이어는 자신의 손에서 문장과 가장 잘 일치하는 카드를 선택하고 선택한 카드를 다른 사람에게 보여주지 않고 이야기꾼에게 전달합니다.\r\n이야기꾼은 자신의 카드와 받은 카드를 모두 섞은 다음 이 카드를 모두 공개합니다. 그러면 이야기꾼을 제외한 각 플레이어는 어떤 카드가 이야기꾼의 카드인지 비밀리에 추측합니다. 아무도 또는 모두가 올바른 카드를 추측하지 못하면 이야기꾼은 0점을 얻고, 다른 플레이어는 2점을 얻습니다. 그렇지 않은 경우, 이야기꾼과 정답을 찾은 사람은 모두 3점을 얻습니다. 또한, 스토리텔러가 아닌 플레이어는 자신의 카드에서 받은 표마다 1점을 얻습니다.\r\n덱이 비어 있거나 플레이어가 최소 30점을 획득하면 게임이 종료됩니다. 두 경우 모두 가장 많은 점수를 얻은 플레이어가 승리합니다.\r\nDixit 기본 게임과 각 확장팩 에는 84장의 카드가 포함되어 있으며 원하는 대로 카드를 혼합할 수 있습니다.', 1, './img/20-3.png', '카드게임/파티게임', NULL),
(4, '할리갈리', 'Halli Galli', '1990-11-07', 'Easy', 2, 6, '10분', '빠른 손놀림과 집중이 중요하며, 종종 혼란을 피하는 것이 도움이 됩니다. 주의 깊게 카드를 관찰하고, 규칙에 따라 종을 치는 시기를 놓치지 않도록 하세요.', 'Halli Galli 는 플레이어가 정확히 5개의 과일 세트를 지켜보는 스피드 액션 게임입니다. 이 덱에는 1~5개의 그룹으로 구성된 4가지 과일을 보여주는 56장의 카드와 호텔 리셉션 데스크에 있는 유형의 종이 포함되어 있습니다.\r\n\r\n덱은 플레이어들 사이에 균등하게 분배됩니다. 모든 플레이어는 자신의 덱을 뒤집어 놓고 차례대로 카드 한 장을 앞면이 보이도록 놓습니다. 각 플레이어가 다음 카드를 공개할 때, 테이블 위에 한 종류의 과일이 총 5개 있는 것을 보는 순간 종을 누르십시오. 당신의 말이 맞다면, 플레이한 카드를 모두 모아서 덱에 넣으세요. 당신이 틀렸다면, 당신은 다른 플레이어들에게 각각 한 장의 카드를 지불합니다. 카드가 부족하면 아웃됩니다. 두 명의 플레이어가 남으면 종을 한 번 더 칠 때까지 플레이한 다음 게임이 종료되고 더 큰 덱이 승리합니다.\r\n\r\n카드가 공개될 때와 가려질 때 모두 5종 카드가 발생할 수 있다는 점을 명심하세요. 예를 들어, 3개, 1개, 4개의 바나나가 표시된 카드가 테이블 위에 있고 3개가 바나나가 아닌 카드로 덮여 있으면 갑자기 5개의 바나나가 표시되고 누군가 종을 향해 손을 뻗는 것이 좋습니다.', 1, './img/20-4.png', '카드게임', NULL),
(5, '부루마불', 'Blue Marble', '1982-11-07', 'Normal', 2, 4, '90분', '자원을 효과적으로 활용하고 전략적으로 건물을 배치하는 것입니다. 자원 관리와 건물 배치를 신중하게 계획하여 자원의 부족을 최소화하고 도시를 발전시키세요.', '한국의 모노폴리 모조품. \"거리\"를 구매하는 대신 \"도시\"를 구매하는 것입니다(서울이 보드워크를 대체함). 자신의 도시를 방문하면 다양한 건물을 지을 수 있습니다. 커뮤니티 상자와 기회 카드는 일종의 보너스나 페널티를 제공하는 하나의 \"키\" 카드로 통합됩니다.그 외에는 독점과 거의 동일합니다. 굴리고, 이동하고, 토지를 구매하거나, 누군가 이미 소유하고 있는 경우 임대료를 지불합니다. 가장 많은 돈을 가진 플레이어가 승리합니다.', 2, './img/20-5.png', '경제/건설', NULL),
(6, '아캄 호러: 카드 게임', 'Arkham Horror: The Card Game', '2016-11-07', 'Hard', 1, 2, '90분', '카드 덱을 효율적으로 구성하고, 리소스를 효과적으로 활용하며, 팀원 간 협력과 조화를 유지하는 것이 중요합니다. 게임에서의 선택과 희생은 매우 중요하며, 대다수의 시나리오는 결정적인 순간을 제시하므로 주의 깊게 계획하고 판단하는 것이 승리의 열쇠가 될 것입니다. 게임을 플레이하면서 플롯트 기술을 향상시키고 상상력을 발휘하는 것도 중요합니다.', '아캄에서 사악한 일이 일어나고 있습니다. 오직 당신만이 그것을 막을 수 있습니다. 롤플레잉과 카드 게임 경험 사이의 전통적인 경계를 모호하게 만드는 Arkham Horror: The Card Game 은 Lovecraftian 미스터리, 괴물, 광기가 담긴 살아있는 카드 게임입니다!\r\n\r\n게임에서 귀하와 귀하의 친구(또는 2개의 코어 세트를 보유한 최대 3명의 친구)는 뉴잉글랜드의 조용한 마을인 아캄의 캐릭터가 됩니다. 물론 당신에게는 재능이 있지만 결점도 있습니다. 아마도 당신은 네크로노미콘 의 글에 너무 많이 손을 대어 그 내용이 계속해서 당신을 괴롭힐 수도 있습니다. 어쩌면 당신은 더 많은 사람들의 조용한 신뢰를 보호하기 위해 자신의 조사를 방해하고 다른 세상의 악의 징후를 은폐해야 한다고 느낄 수도 있습니다. 어쩌면 당신은 끔찍한 숭배 집단과의 만남으로 인해 상처를 입을 수도 있습니다.\r\n\r\n무엇이 당신을 강요하든, 무엇이 당신을 괴롭히든 상관없이, 맞춤형 카드 덱에 반영된 강점과 약점을 모두 발견할 수 있으며, 친구들과 협력하여 세계에서 가장 무서운 미스터리를 풀 때 이 카드는 자원이 될 것입니다.\r\n\r\nArkham Horror LCG 의 각 모험은 여러분을 더 깊은 미스터리 속으로 안내합니다. 당신은 이교도와 더러운 의식을 발견하게 될 것입니다. 유령의 집과 이상한 생물을 발견하게 될 것입니다. 그리고 우리 세계의 장벽에 맞서 싸우고 있는 고대의 존재들의 흔적을 발견할 수도 있습니다.\r\n\r\nArkham LCG 의 기본 플레이 모드는 모험이 아닌 캠페인입니다. 모험으로 인해 상처를 입을 수도 있고, 정신이 긴장될 수도 있으며, 아컴의 풍경을 바꿔 건물을 불태울 수도 있습니다. 귀하의 모든 선택과 행동은 당면한 시나리오의 즉각적인 해결을 훨씬 넘어서는 결과를 가져오며, 귀하의 행동은 귀하 앞에 놓인 모험에 더 잘 대비할 수 있는 귀중한 경험을 얻을 수 있습니다.', 1, './img/20-6.png', '호러/카드', NULL),
(7, '브라스: 랭커셔', 'Brass: Lancashire', '2007-11-07', 'Hard', 2, 4, '90분', '효율적인 리소스 관리와 건물의 전략적 배치입니다. 자원과 자금을 최대한 효율적으로 활용하여 섬유 공장과 광산을 운영하고, 수송망을 통해 상품을 시장으로 운송하세요. 또한 경제적 효율성과 상대 플레이어의 움직임을 주시하며, 플레이어 간 경쟁을 고려하여 전략을 세우는 것이 승리의 열쇠가 될 것입니다.', 'Brass는 산업 혁명 당시 Lancashire에서 경쟁하던 목화 기업가들의 이야기를 다룬 경제 전략 게임입니다. 철, 석탄, 면화에 대한 수요를 활용할 수 있도록 산업과 네트워크를 개발, 구축 및 확립해야 합니다. 게임은 운하 단계와 철도 단계의 두 부분으로 나누어 진행됩니다. 게임에서 승리하려면 각 전반전이 끝날 때 계산되는 가장 많은 승점(VP)을 획득하세요. 승점은 운하, 난간 및 확립된(뒤집힌) 산업 타일에서 얻습니다. 각 라운드마다 플레이어는 턴 순서 트랙에 따라 차례대로 진행되며 다음 중 하나를 수행하기 위한 두 가지 작업을 받습니다.\r\n\r\n산업 타일 구축\r\n철도나 운하를 건설하세요\r\n산업을 발전시키다\r\n목화 판매\r\n대출을 받아\r\n플레이어의 차례가 끝나면 자신이 사용한 두 장의 카드를 덱에서 두 장 더 교체. 턴 순서는 플레이어가 이전 턴에 지출한 돈의 양에 따라 가장 낮은 금액부터 가장 높은 금액부터 결정됩니다. 이 턴 순서 메커니즘은 턴 순서 후반에 진행하는 플레이어에게 몇 가지 전략적 옵션을 열어 연속 턴의 가능성을 허용합니다.\r\n\r\n처음으로 모든 카드를 사용한 후(플레이어 수에 따라 덱 크기가 조정됨) 운하 단계가 종료되고 득점 라운드가 시작됩니다. 점수를 매긴 후에는 모든 운하와 가장 낮은 수준의 산업이 게임에서 제거되고, 그 후 새 카드가 처리되고 철도 단계가 시작됩니다. 이 단계에서 플레이어는 이제 도시에서 두 개 이상의 위치를 ​​차지할 수 있으며 이중 연결 구축(비용이 많이 들지만)이 가능합니다. 레일 단계가 끝나면 또 다른 득점 라운드가 진행되고 승자가 결정됩니다.\r\n\r\n산업을 건설할 수 있는 카드는 제한되어 있지만 면화 개발, 판매 또는 연결 구축 작업에는 모든 카드를 사용할 수 있습니다. 이는 카드의 전략적 타이밍/저장으로 이어집니다. 자원은 공통적이므로 한 플레이어가 (석탄이 필요한) 철도를 건설하는 경우 가장 가까운 소스에서 석탄을 사용해야 하며, 이는 상대방의 탄광일 수 있으며, 결과적으로 해당 탄광은 점수에 더 가까워집니다.', 2, './img/20-7.png', '경제', NULL),
(8, '북해의 침입자', 'Raiders of the North Sea', '2015-11-07', 'Normal', 2, 4, '70분', '자원 관리와 레이드 시기 선택이 중요합니다. 자원을 모으고 큰 레이드를 수행하는 적절한 시기를 찾는 것이 승리의 열쇠가 됩니다. 또한 레이드 시에 승리 포인트를 획득하기 위해 필요한 자원과 노동자를 효율적으로 조절하며 게임을 진행하세요.', '북해의 침입자(Raiders of the North Sea)는 바이킹 시대의 중앙을 배경으로 합니다. 바이킹 전사로서 플레이어는 의심하지 않는 정착지를 습격하여 족장에게 깊은 인상을 남기려고 노력합니다. 그러기 위해 플레이어는 승무원을 모으고, 식량을 모으고, 북쪽으로 여행하여 금, 철, 가축을 약탈해야 합니다. 전투에서는 영광을 찾을 수 있습니다. 심지어 발키리의 손에서도 찾을 수 있습니다. 습격 시즌이니까 전사들을 모아주세요!족장에게 깊은 인상을 남기려면 승점(VP)이 필요하며, 승점은 주로 정착지를 습격하고, 약탈하고, 족장에게 제물을 바쳐 획득. 약탈물을 어떻게 사용하는가 또한 성공에 매우 중요합니다. 플레이어는 시계 방향 순서로 차례대로 진행하며, 차례에 일꾼을 배치하고 해당 작업을 해결한 다음 다른 일꾼을 집어 들고 해당 작업을 해결합니다. 대체로 이러한 작업은 다음 두 가지 범주 중 하나에 속합니다.\r\n작업: 성공적인 공격대를 확보하려면 좋은 승무원과 충분한 식량을 확보하는 것이 중요하므로 공격대를 시작하기 전에 플레이어는 승무원을 준비하고 보급품을 수집하기 위한 몇 가지 작업을 수행해야 합니다. 이 모든 작업은 다양한 액션을 제공하는 8개의 건물이 있는 게임 보드 하단의 마을에서 이루어집니다. 먼저 다른 작업자가 없는 사용 가능한 건물에 작업자를 배치한 다음 다른 건물에서 다른 작업자를 픽업해야 합니다.\r\n습격: 플레이어가 충분한 승무원을 고용하고 식량을 수집한 후에는 자신의 차례에 습격을 선택할 수 있습니다. 항구, 전초 기지, 수도원, 요새 등 정착지를 습격하려면 다음 세 가지 요구 사항을 충족해야 합니다. 충분한 규모의 승무원, 충분한 식량(수도원 및 요새를 위한 금, 적절한 색상의 일꾼) 확보. 군사력, 약탈, 회색과 백인 노동자가 게임에 참여하는 방식인 발키리 등 다양한 득점 방법을 제공합니다.\r\n요새 습격이 하나만 남거나 모든 발키리가 제거되거나 모든 제안이 완료되면 게임이 종료되며 플레이어는 점수를 집계합니다.', 2, './img/20-8.png', '전략', NULL),
(9, '체스', 'Chess', '1475-11-07', 'Normal', 2, 2, '30~60분', '개별 말들의 특성과 역할을 잘 이해하고, 체스는 전략 게임이므로 기민한 판단과 상대방의 미래 움직임을 예측하는 능력이 중요합니다. 계속 연습하며 기술을 향상시키세요.', '룰설명:말의 배치- 체스 게임은 흰색과 검은색 말로 이루어져 있습니다. 각 플레이어는 1개의 킹, 1개의 퀸, 2개의 룩, 2개의 비숍, 2개의 나이트, 그리고 8개의 폰을 가지고 시작합니다. 말들은 플레이어의 초기 행에서 시작하며, 흰색 퀸은 흰색 칸, 검은색 퀸은 검은색 칸에서 시작합니다.\r\n이동 규칙-킹: 한 번에 한 칸씩 수직, 수평 또는 대각선으로 이동할 수 있습니다.\r\n퀸: 수직, 수평, 대각선 방향으로 무한대로 이동할 수 있습니다.\r\n룩: 수직 또는 수평 방향으로 무한대로 이동할 수 있습니다.\r\n비숍: 대각선 방향으로 무한대로 이동할 수 있습니다.\r\n나이트: \"L\"자 모양으로 이동할 수 있으며, 다른 말을 뛰어넘을 수 있습니다.\r\n폰: 초기에는 두 칸까지 이동 가능하지만 이후에는 한 칸씩 수직으로만 이동할 수 있으며, 상대방 말을 잡을 때는 대각선으로 이동합니다.\r\n체크와 체크메이트: 플레이어의 킹이 상대방의 말에 의해 공격 당하면 \"체크\" 상태가 되며, 이때 킹을 구원할 수 있는 수를 수행해야 합니다. 플레이어의 킹을 공격할 수 있는 방법이 없을 때 \"체크메이트\"가 선언되며, 게임이 종료됩니다.\r\n특수 규칙-\"앙파상\" 규칙: 폰이 두 칸 이동하여 상대방 폰을 우회하는 경우, 상대방은 그 폰을 공격할 수 있는 특수한 움직임을 사용할 수 있습니다.\r\n체스는 전략, 계산, 예측, 그리고 미리 계획을 포함하는 게임입니다. 상대방의 말의 이동과 위치를 예측하여 말을 움직이고, 플레이어의 목표는 상대방의 킹을 체크메이트하여 승리하는 것입니다.', 2, './img/20-9.png', '전략', NULL),
(10, '카베르나: 동굴 농부들', 'Caverna: The Cave Farmers', '2013-11-07', 'Hard', 1, 7, '30~210분', '자원 관리와 공간 활용이 중요합니다. 효과적인 광산, 농장, 가축 관리와 채취한 자원을 잘 활용하여 가족을 늘리고 보너스 점수를 얻는 전략을 세우세요.\r\n', '전작인 Agricola 와 같은 노선을 따르는 Caverna: The Cave Farmers는 본질적으로 농업에 초점을 맞춘 일꾼 배치 게임입니다 . 게임에서 당신은 산속의 작은 동굴에 사는 작은 난쟁이 가족의 수염을 기른 ​​지도자입니다. 농부와 그의 배우자로 게임을 시작하며, 농가의 각 구성원은 플레이어가 매 턴마다 취할 수 있는 행동을 나타냅니다. 당신은 함께 동굴 앞의 숲을 가꾸고 산 속으로 더 깊이 파고듭니다. 당신은 동굴을 당신의 자손을 위한 거주지이자 소규모 기업의 작업 공간으로 제공합니다.\r\n\r\n채굴할 광석의 양은 귀하에게 달려 있습니다. 보너스 아이템과 행동을 얻기 위해 원정을 떠날 수 있는 무기를 제작하려면 이 정보가 필요합니다. 산을 파는 동안 수원을 발견하고 부를 늘리는 데 도움이 되는 광석과 루비 광산을 발견할 수도 있습니다. 동굴 바로 앞에서 농업을 통해 부를 더욱 늘릴 수 있습니다. 숲을 베어 밭에 씨를 뿌리고 목초지에 울타리를 쳐 동물을 키울 수 있습니다. 계속해서 성장하는 농장을 운영하면서 가족을 확장할 수도 있습니다. 결국, 가장 효율적으로 홈보드를 개발한 플레이어가 승리합니다.\r\n\r\n또한 이 게임의 솔로 변형을 플레이하여 동굴의 48가지 다양한 가구 타일에 익숙해질 수도 있습니다.\r\n\r\n플레이어당 약 30분의 플레이 시간을 제공하는 Caverna: The Cave Farmers 는 이전 게임의 카드 덱을 건물 세트로 대체하는 동시에 무기 구매 및 농부를 보낼 수 있는 기능을 추가한 Agricola 의 완전한 재설계입니다. 추가 자원을 얻기 위한 퀘스트입니다. 디자이너 Uwe Rosenberg는 게임에 Agricola 의 일부가 포함되어 있지만 새로운 아이디어, 특히 광산을 건설하고 루비를 검색할 수 있는 게임 보드의 동굴 부분도 포함되어 있다고 말합니다. 이 게임에는 개와 당나귀라는 두 가지 새로운 동물도 포함되어 있습니다.', 2, './img/20-10.png', '자원/전략', NULL),
(11, '블러드 레이지', 'Blood Rage', '2015-11-07', 'Hard', 2, 4, '75분', '\"블러드 레이지\"에서 승리하려면 전투 전략과 카드 관리가 핵심입니다. 플레이어들은 자신의 군대를 강화하고 상대방을 공격하여 테리토리를 확장하고 포인트를 얻어야 합니다.', '세션 시작- 각 플레이어는 자신의 클랜과 미니어처 군대를 갖고 시작합니다. 미니어처 군대는 군사, 독수리, 신, 백조 및 트롤 등의 다양한 미니어처로 이루어져 있으며, 각각 고유한 특성과 능력을 가집니다.\r\n\r\n영역 제어- 플레이어들은 테리토리 카드로부터 랜덤으로 공개된 테리토리 중 하나를 선택하여 본인의 지배 아래로 넣습니다. 이를 통해 지배 영토를 확장하고 전략을 세울 수 있습니다.\r\n\r\n카드 획득-각 턴마다 카드를 뽑아 플레이합니다. 카드에는 전투, 기이한 능력, 모험 등 다양한 효과가 있으며, 이 카드를 통해 전투에서 이길 확률을 높이거나 특별한 능력을 사용할 수 있습니다.\r\n\r\n전투- 플레이어들은 턴 동안 원하는 테리토리에 미니어처를 이동시키고, 다른 플레이어의 미니어처와 전투할 수 있습니다. 전투는 카드 및 미니어처의 능력에 따라 진행됩니다. 이긴 플레이어는 테리토리를 지배하며, 패배한 플레이어는 해당 미니어처를 \'발사\'하여 다른 테리토리로 이동합니다.\r\n\r\n업그레이드- 플레이어들은 게임 진행 중 미니어처를 업그레이드하고, 특별한 능력을 부여할 수 있습니다.\r\n\r\n종료와 포인트- 게임은 세션마다 특정 횟수의 테리토리 지배 후 종료됩니다. 포인트는 지배한 테리토리, 미니어처 카드, 카드 능력 등으로 얻습니다. 가장 많은 포인트를 얻은 플레이어가 승리합니다.\r\n\r\n한 가지 주의할 점은 \"블러드 레이지\"는 복잡한 전략과 전투 요소를 가지고 있으므로, 게임 규칙을 완벽히 숙지하고 팀원과의 협력을 고려하는 것이 중요합니다.', 2, './img/20-11.png', '전략/카드', NULL),
(12, '팬데믹', 'Pandemic', '2008-11-07', 'Normal', 2, 4, '45분', '\"팬데믹\"에서 효율적인 협력과 커뮤니케이션이 중요하며, 각 플레이어는 역할과 전문 지식을 활용하여 최상의 전략을 수립해야 합니다.', '팬데믹(Pandemic) 에서는 여러 가지 악성 질병이 전 세계적으로 동시에 발생했습니다! 플레이어는 질병과 싸우는 전문가로서 질병이 집중된 곳을 치료하는 동시에 네 가지 전염병이 통제 불능에 빠지기 전에 각각에 대한 치료법을 연구하는 것을 임무로 합니다.\r\n\r\n게임 보드는 지구상의 여러 주요 인구 중심지를 묘사합니다. 매 턴마다 플레이어는 최대 4가지 액션을 사용하여 도시 간 이동, 감염된 인구 치료, 치료법 발견, 연구 기지 건설 등을 수행할 수 있습니다. 카드 덱은 플레이어에게 이러한 능력을 제공하지만 이 덱 전체에는 전염병이 흩뿌려져 있습니다! 질병의 활동을 가속화하고 강화하는 카드입니다. 두 번째 별도의 카드 덱은 감염의 \"정상적인\" 확산을 제어합니다.\r\n\r\n팀 내에서 독특한 역할을 맡은 플레이어는 질병을 극복하기 위해 전문가의 강점과 조화를 이루는 전략을 계획해야 합니다. 예를 들어, 운영 전문가는 질병 치료법을 찾는 데 필요하고 도시 간 이동성을 높이는 데 필요한 연구 스테이션을 구축할 수 있습니다. 과학자는 특정 질병을 치료하기 위해 일반적인 5장의 카드 대신 4장의 카드만 필요합니다. 그러나 질병은 빠르게 퍼지고 있으며 시간이 부족합니다. 하나 이상의 질병이 회복할 수 없을 정도로 퍼지거나 너무 많은 시간이 경과하면 플레이어는 모두 패배합니다. 네 가지 질병을 치료하면 모두 승리합니다!\r\n', 1, './img/20-12.png', '카드/협력', NULL),
(13, '광기의 저택: 세컨드 에디션', 'Mansions of Madness: Second Edition', '2016-11-07', 'Hard', 1, 5, '150분', '\"광기의 저택\"에서는 팀원 간의 협력과 정보 공유가 중요합니다. 탐사와 퍼즐 해결에 집중하고, 특수 능력을 활용하여 공포와 괴이한 사건을 극복하세요.', '플레이어들은 차례대로 움직이며, 이동 및 탐사, 아이템 사용, 공격 및 조사와 같은 행동을 선택할 수 있습니다.\r\n탐사할 때마다 앱을 사용하여 해당 지역에 대한 설명과 이벤트를 확인하며, 그에 따른 행동을 결정합니다.\r\n앱은 게임의 스토리를 진행하고, 종종 이벤트와 퍼즐을 풀게 합니다. 미스터리와 공포 요소를 다룹니다.\r\n게임 목표:\r\n\r\n게임의 목표는 스토리에 따라 다릅니다. 일반적으로 플레이어들은 저택 내에서의 미스터리를 해결하거나 특정 과제를 완료해야 합니다.\r\n플레이어들은 시간 제한 내에 이런 목표를 달성해야 하며, 실패할 경우 게임 오버됩니다.\r\n협력과 전투:\r\n\r\n게임 내에서 협력이 중요하며, 플레이어들은 정보를 공유하고 함께 퍼즐을 해결해야 합니다.\r\n때때로 게임은 공포 요소와 전투 상황을 제시하며, 플레이어들은 적을 처치하고 위험을 극복해야 합니다.\r\n\"광기의 저택: 세컨드 에디션\"은 앱을 통해 게임 스토리를 진행하고 이벤트를 제공하며, 플레이어들은 앱과 보드를 함께 사용하여 게임을 진행합니다. 게임 내에서 공포와 스릴을 느끼며, 미스터리를 풀고 퀘스트를 완료하는 것이 목표입니다.', 1, './img/20-13.png', '협동/미스터리/공포', NULL),
(14, '리스보아', 'Lisboa', '2017-11-07', 'Normal', 1, 4, '90분', '리스본을 재건하려면 건물 건설과 왕실 명령을 효율적으로 활용하고, 장기 목표를 달성하며 문화 점수를 얻는 전략을 수립하세요. 효율적인 리소스 관리가 승리의 열쇠입니다.', '역사적 배경을 가진 전략적 보드 게임으로, 18세기 리스본 지진과 이를 따르는 재건에 중점을 두고 있습니다. 게임은 플레이어들이 리스본을 재건하고 도시의 발전에 기여하는 과정을 다룹니다. 아래에 게임의 주요 룰을 간략하게 설명합니다:\r\n\r\n게임 목표: \"리스보아\"의 목표는 리스본의 재건에 기여하고, 각 플레이어의 승리 조건을 달성하는 것입니다. 승리 조건은 리스본을 재건하거나, 문화 점수를 획득하거나, 왕실 명령을 이행하여 발전에 기여하는 등 다양합니다.\r\n\r\n게임 보드: 게임 보드에는 리스본의 각 지역, 건물 및 행정 구역이 나타나며, 플레이어들은 이를 조사하고 건설하며 도시를 발전시킵니다.\r\n\r\n행동 카드: 각 플레이어는 손에 행동 카드를 가지고 시작하며, 이 카드들을 사용하여 행동을 결정합니다. 행동 카드에는 건물 건설, 수리, 확장, 조사 및 상점 운영 등 다양한 행동이 포함되어 있습니다.\r\n\r\n장기 목표 카드: 게임 시작 시, 장기 목표 카드를 선택하며, 이 카드에 명시된 목표를 달성하는 것이 승리에 중요합니다. 목표는 건물 건설, 문화 점수 획득, 왕실 명령 이행 등이 될 수 있습니다.\r\n\r\n왕실 명령: 왕실 명령은 플레이어들이 리스본을 발전시키고 도시를 재건하는 데 중요한 요소입니다. 이 명령을 수행하면 보상을 받습니다.\r\n\r\n점수 획득: 게임에서는 문화 점수를 얻는 것이 중요하며, 이는 리스본을 재건하고 도시 발전에 기여함으로 얻을 수 있습니다.\r\n\r\n게임 종료: 게임은 특정 조건을 만족하거나 특정 순서로 미션 카드를 소진할 때 종료됩니다. 게임 종료 후 플레이어들은 승리 조건을 검토하고 승자를 결정합니다.\r\n\r\n\"리스보아\"는 깊이 있는 전략과 경제적 요소가 포함된 복잡한 보드 게임입니다. 플레이어들은 건물을 건설하고 재건을 진행하며 목표를 달성하기 위한 전략을 세워야 합니다. 게임의 룰을 숙지하고 경제 및 리소스 관리를 효율적으로 수행하는 것이 승리에 중요합니다.', 1, './img/20-14.png', '경제/전략', NULL),
(15, '위자드', 'Wizard', '1984-11-07', 'Normal', 3, 6, '45분', '\"위자드\"에서는 상대 플레이어들의 패를 추측하고, 무승부를 최소화하며 승리하기 위해 전략적으로 카드를 플레이하세요. 카드 순서와 예측이 승리의 핵심입니다.', '트릭 테이킹 게임 Wizard는 4개의 Wizards(높음) 및 4개의 Jesters(낮음)와 함께 전통적인 52개 카드 덱(4개 슈트에 1-13개)으로 구성된 60개 카드 덱을 사용합니다.\r\n\r\n플레이어는 플레이어 수에 따라 여러 라운드에 걸쳐 경쟁하며, 가장 높은 점수를 얻은 사람이 승리합니다. 각 라운드에서 플레이어는 첫 번째 라운드에서 카드 한 장, 두 번째 라운드에서 두 장, 세 번째 라운드에서 세 장 등 카드 한 장을 받습니다. 그런 다음 언딜트 덱의 맨 위 카드를 뒤집어 트럼프를 결정합니다. 수트가 공개되면 그 수트는 트럼프이고, 카드가 공개되면 Jester이면 거절되고 해당 라운드에는 트럼프가 없습니다. 나온 카드가 마법사인 경우 딜러는 4개의 슈트 중 하나를 트럼프 슈트로 선택합니다. 딜러는 \"트럼프 없음\"을 선택할 수 없습니다. 각 게임의 마지막 라운드에서는 모든 카드가 분배되므로 트럼프가 없습니다. 그런 다음 플레이어는 라운드에서 승리할 것으로 예상되는 트릭 수를 말합니다.\r\n\r\n트릭의 플레이와 승리는 대부분 표준 트릭 테이킹 규칙을 사용합니다. 플레이어가 적합한 카드를 리드하면 가능하면 다른 모든 플레이어도 해당 카드를 따라야 합니다. 플레이어가 Jester를 이끄는 경우 두 번째 플레이어가 이끄는 슈트를 결정합니다. 플레이어가 마법사를 이끄는 경우, 따르는 사람들은 원하는 대로 플레이할 수 있습니다. 그러나 모든 경우에 플레이어는 수트 주도의 카드를 보유하고 있더라도 항상 마법사나 광대를 사용할 수 있습니다.\r\n\r\n각 플레이어가 카드를 사용한 후 다음과 같이 트릭의 승자를 결정합니다. 하나 이상의 마법사를 사용했다면 첫 번째 마법사의 플레이어가 트릭에서 승리하고 카드를 모아 다음 트릭으로 이어집니다. 그렇지 않다면, 가장 높은 트럼프를 낸 사람이 트릭을 이기게 됩니다. 그렇지 않은 경우, 해당 슈트에서 가장 높은 카드를 낸 사람이 트릭을 이기게 됩니다. 모든 플레이어가 광대를 플레이했다면, 먼저 광대를 플레이한 사람이 승리합니다.\r\n\r\n모든 트릭을 플레이한 후 플레이어는 해당 라운드의 점수를 집계합니다. 플레이어가 자신의 입찰에 맞춰 라운드 시작 시 명시된 만큼의 트릭을 정확하게 획득한 경우, 플레이어는 20점을 획득하고 각 트릭에 대해 10점을 추가로 얻습니다. 플레이어가 입찰을 놓치면 예상보다 많이 가져갔든 적게 가져갔든 관계없이 자신이 벗어난 트릭마다 10점을 잃습니다.\r\n\r\nWizard 의 일반적인 변형은 라운드에서 입찰한 총 트릭 수가 라운드 수와 일치하지 않도록 하여 (적어도) 한 명의 플레이어가 각 라운드에서 나가도록 하는 것입니다.', 1, './img/20-15.png', '전략/판타지/카드게임', NULL),
(16, '산토리니', 'Santorini', '2016-11-07', 'Normal', 2, 4, '20분', '\"산토리니\"에서는 건설과 이동을 조합하여 상대 플레이어를 이기는 전략을 사용하세요. 높은 레벨의 전략적 사고가 승리의 열쇠입니다.', '규칙은 간단합니다. 각 턴은 2단계로 구성됩니다.\r\n\r\n이동 - 건축업자 중 한 명을 이웃 공간으로 이동합니다. Builder Pawn을 같은 레벨로 이동하거나, 한 레벨 올리거나, 원하는 만큼 레벨을 내릴 수 있습니다.\r\n\r\n건축 - 그런 다음 이동한 건축업자 옆에 건물 층을 건설합니다. 3층 꼭대기에 건물을 지을 때는 대신 돔을 배치하여 해당 공간을 플레이에서 제거하세요.\r\n\r\n게임 승리 - 건축가 중 한 명이 세 번째 레벨에 도달하면 승리합니다.\r\n\r\n가변적인 플레이어 능력 - 산토리니는 게임 플레이 방식을 근본적으로 바꾸는 40가지 테마의 신과 영웅 능력을 갖춘 추상적인 게임 위에 계층화된 가변적인 플레이어 능력을 특징으로 합니다.', 1, './img/20-16.png', '건설/전략', NULL),
(17, '레지스탕스: 아발론', 'The Resistance: Avalon', '2012-11-07', 'Normal', 5, 10, '30분', '\"레지스탕스: 아발론\"에서 의심과 신뢰의 미묘한 균형을 찾으며, 정보 공유와 추론을 통해 스파이를 식별하거나 위장하여 목표를 달성하세요. 의사소통과 심리전이 승리의 열쇠입니다.', '게임의 주요 룰은 다음과 같습니다:\r\n\r\n역할 분배: 플레이어들은 차례대로 역할 카드를 받아 \"팀원\" 또는 \"스파이\"가 됩니다. 스파이는 팀원으로 위장하여 목표를 방해해야 합니다.\r\n\r\n임무 카드: 게임의 각 라운드에서, 플레이어들은 임무 카드를 사용하여 어떤 플레이어가 어떤 임무를 수행할지 결정합니다. 예를 들어, \"3명의 팀원이 \'성공\'을 투표하면 성공하며, 2명의 스파이와 1명의 팀원이 \'실패\'를 투표하면 실패한다\"와 같은 임무가 주어집니다.\r\n\r\n임무 투표: 모든 플레이어는 그들이 할당받은 임무에 대해 \"성공\" 또는 \"실패\"로 투표합니다. 투표 결과에 따라 임무가 성공 또는 실패로 진행됩니다.\r\n\r\n정체성 숨김: 게임은 플레이어들이 스파이인지 팀원인지 추론하는 과정으로 진행됩니다. 스파이는 위장하여 임무를 방해하려고 노력하고, 팀원은 스파이를 식별하려고 노력합니다.\r\n\r\n게임 종료: 게임은 스파이가 일정 횟수의 임무를 방해하거나 팀원이 스파이를 찾아내거나 스파이가 모든 임무를 성공시키면 종료됩니다.\r\n\r\n정체성 공개: 게임 종료 후, 플레이어들은 각자의 역할을 공개하고 게임에서 어떤 일이 일어났는지 토의합니다.\r\n\r\n\"레지스탕스: 아발론\"은 플레이어 간의 의심과 신뢰를 중점으로 두며, 팀원과 스파이 간의 미묘한 심리전을 다루는 협력 및 추론 게임입니다. 게임은 반복되는 임무와 정체성 숨김 요소를 통해 재미와 긴장감을 제공합니다.', 1, './img/20-17.png', '협력/추리/블러핑', NULL),
(18, '시크릿 히틀러', 'Secret Hitler', '2016-11-07', 'Normal', 5, 10, '45분', '\"시크릿 히틀러\"에서는 의심과 신뢰가 중요하며, 당신의 정체성과 이탈리아 정부를 파악하고, 의심스러운 플레이어를 발견하여 정상적인 정부를 형성하는 데 기여하세요. 팀원과 스파이의 상황을 분석하고 논리적으로 판단하세요.', '파티 게임으로, 플레이어들은 나치 독일의 역사 배경에서 정부와 스파이의 역할을 플레이합니다. 게임은 정부를 구성하는 플레이어들과 스파이 플레이어로 나누어져 있으며, 스파이들은 히틀러를 지키기 위해 정부의 정책을 좌우하려고 노력합니다.\r\n\r\n게임 세팅:\r\n플레이어 수에 따라 역할 카드를 나누어 줍니다. 역할 카드에는 정부 구성원과 스파이 역할이 포함되어 있습니다.\r\n게임 보드를 설치하고, 정부 구성원들이 스파이를 식별할 수 있도록 역할 카드를 숨긴 채로 게임을 시작합니다.\r\n\r\n게임 흐름:\r\n게임은 라운드로 진행되며, 각 라운드에서 정부 구성원들은 정책 카드를 드로우하고 그 중 하나를 골라야 합니다. 정책 카드에는 자유당과 나치당 정책이 있습니다. 정부 구성원들은 나치 정책을 플레이하면서 스파이를 식별하려고 노력합니다.\r\n정부 구성원들은 라운드마다 정책을 선택하고 투표를 진행합니다. 이 투표는 어떤 정책이 선택되어야 하는지를 결정합니다.\r\n스파이 플레이어들은 스파이 카드를 드로우하고, 정부 구성원들에게 나치 정책을 선택하도록 설득하려고 노력합니다.\r\n정부 구성원들은 라운드가 진행되면서 나치 정책을 플레이하거나 자유당 정책을 플레이하게 됩니다.\r\n\r\n게임 종료:\r\n게임은 다양한 조건으로 종료할 수 있습니다. 정부 구성원들이 5개의 자유당 정책을 통과하면 승리합니다. 스파이 플레이어들이 6개의 나치 정책을 통과하면 승리합니다.\r\n게임 종료 후, 정부 구성원들은 역할을 공개하고, 스파이와 정부 구성원의 승리 여부를 확인합니다.\r\n\"시크릿 히틀러\"는 미묘한 정보 전달과 협력, 의심과 판단을 중점으로 하는 게임입니다. 스파이와 정부 구성원 간의 상호 작용과 의사소통이 게임의 핵심이며, 미스터리와 흥미를 제공합니다\r\n', 1, './img/20-18.png', '협력/블러핑', NULL),
(19, '우노', 'Uno', '1971-11-07', 'Easy', 2, 10, '30분', '게임에서는 카드 수를 최대한 빨리 소진하려면 기회가 올 때마다 카드를 낸다. 다른 플레이어가 많은 카드를 가지고 있을 때 특히 고려해야 합니다. 게임의 핵심은 전략적으로 맞춰 가지고 있는 카드를 플레이하여 상대방을 공략하고 승리하는 것입니다.', '게임 시작:\r\n\r\n2명 이상의 플레이어가 참가할 수 있습니다.\r\n각 플레이어에게 7장의 카드가 나누어집니다.\r\n남은 카드 덱에서 맨 위의 카드를 뒤집어, 시작 카드로 사용합니다.\r\n턴 진행:\r\n\r\n각 턴에서 플레이어는 다음 중 하나를 할 수 있습니다:\r\n하나의 카드를 낼 수 있으며, 이 카드는 숫자나 색깔이 맞아야 합니다.\r\n특수 카드(예: \"Skip\", \"Reverse\", \"Draw Two\", \"Wild\", \"Wild Draw Four\")를 사용할 수 있습니다. 이러한 카드는 특수 규칙을 적용하거나 다음 플레이어에게 효과를 주는 데 사용됩니다.\r\n색깔과 숫자 맞추기:\r\n\r\n카드를 내는 플레이어는 자신의 카드 중에서 색깔 또는 숫자가 현재 카드와 일치하는 카드를 사용해야 합니다.\r\n특수 카드인 \"Wild\"와 \"Wild Draw Four\"를 낼 때는 어떤 색깔이나 숫자를 선택할 수 있습니다.\r\n특수 카드:\r\n\r\n\"Skip\": 다음 플레이어의 턴을 건너뜁니다.\r\n\"Reverse\": 턴의 방향을 반대로 변경합니다.\r\n\"Draw Two\": 다음 플레이어에게 2장의 카드를 뽑도록 합니다.\r\n\"Wild\": 어떤 색깔을 선택할 수 있으며, 이 카드로 시작할 수 있습니다.\r\n\"Wild Draw Four\": 어떤 색깔을 선택할 수 있으며, 다음 플레이어에게 4장의 카드를 뽑도록 합니다.\r\n카드 뽑기:\r\n\r\n턴을 마칠 때, 플레이어가 해당 턴에 카드를 내지 못하면 그 플레이어는 덱에서 카드를 1장 뽑아야 합니다. 만약 그 카드를 낼 수 있다면, 뽑은 카드를 사용해야 합니다.\r\n우노 외치기:\r\n\r\n플레이어가 마지막 1장의 카드를 낼 때, \"우노 (Uno)\"라고 외쳐야 합니다. 그렇지 않으면 다른 플레이어가 \"우노\"를 외친다면 원래 플레이어가 2장의 카드를 추가로 뽑게 됩니다.\r\n게임 종료:\r\n\r\n한 플레이어가 모든 카드를 손에 없앴을 때 게임이 종료됩니다. 그 플레이어가 승리하며, 남은 플레이어들의 손에 있는 카드의 점수를 합산하여 기록합니다.\r\n\"우노\"는 빠른 판단, 전략, 그리고 예상치 못한 흥미로운 상황을 제공하는 게임입니다. 다양한 특수 카드와 규칙을 활용하여 승리를 향해 나아가야 합니다.', 1, './img/20-19.png', '카드', NULL),
(20, '잉카의 황금', 'Incan Gold', '2006-11-07', 'Normal', 3, 8, '30분', '자원을 효율적으로 활용하고, 목표를 달성하는 전략을 세우세요. 아군과 경쟁 상대를 잘 파악하고, 적절한 타이밍에 골드 마인을 활용하여 승리에 도전하세요.', '플레이어들이 아무래도 트레저 헌터로 참여하여 오래전에 잃어버린 인카의 보물을 찾는 보드 게임입니다룰설명:플레이어들이 아무래도 트레저 헌터로 참여하여 오래전에 잃어버린 인카의 보물을 찾는 보드 게임입니다\r\n게임 준비:\r\n게임 보드 위에 플레이 가능한 경로와 보물 칸을 나타내는 타일을 배치합니다.\r\n트레저 카드를 섞고, 각 플레이어에게 트레저 카드를 몇 장씩 나눠줍니다.\r\n플레이어들은 자신의 캐릭터 카드를 선택하고, 캐릭터 카드에 따른 플레이어 고유의 능력을 활용합니다.\r\n게임 진행:\r\n턴 순서: 각 플레이어는 순서대로 행동합니다. 한 턴 동안에는 다음 중 하나를 선택할 수 있습니다:\r\n카드 뽑기: 트레저 카드 중 하나를 뽑습니다.\r\n카드 놓기: 트레저 카드를 플레이합니다. 이 카드에는 이동, 행동, 방해, 퀘스트 등 다양한 효과가 있습니다.\r\n이동: 플레이어는 캐릭터 카드에 따라 일정 거리를 이동할 수 있습니다. 플레이어가 보물 칸에 도착하면 보물을 얻을 수 있습니다.\r\n행동: 트레저 카드로 플레이어는 다른 플레이어를 공격하거나 방어할 수 있으며, 퀘스트를 수행할 수도 있습니다.\r\n보물 수집: 보물 칸에 도착하면 해당 보물을 수집하고, 트레저 카드로 보물을 수집하도록 선택할 수 있습니다.\r\n승리 조건: 게임의 승리 조건은 특정 퀘스트를 달성하거나, 미션 카드에 나온 목표를 달성하는 것입니다.\r\n게임 종료:\r\n게임은 승리 조건이 충족될 때 또는 덱의 모든 트레저 카드가 소진될 때 종료됩니다.\r\n한줄 팁: 자원을 효율적으로 활용하고, 상대 플레이어와 경쟁상대의 움직임을 예측하여 전략을 세우세요. 게임의 목표와 퀘스트를 주의 깊게 고려하여 승리를 향해 나아가세요.', 0, './img/20-20.png', '탐험/전략', NULL)";
$result = mysqli_query($dbcon, $sql);
if ($result)
    echo "games 테이블 데이터 입력 완료<br>";
else
    echo "games 테이블 데이터 입력 실패<br>";

$sql = "CREATE TABLE `game_likes` (
    `user_id` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `game_id` int NOT NULL,
    PRIMARY KEY (`user_id`,`game_id`),
    KEY `game_id` (`game_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
$result = mysqli_query($dbcon, $sql);
if ($result)
    echo "game_likes 테이블 생성 완료<br>";
else
    echo "game_likes 테이블 생성 실패<br>";

$sql = "CREATE TABLE `member` (
    `user_id` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `userpassword` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `username` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `useremail` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `registration_date` date DEFAULT NULL,
    `user_settings` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    `account_status` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `admin` int DEFAULT '0',
    `user_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    `token_expiry` datetime DEFAULT NULL,
    `reset_completed` tinyint(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`user_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
$result = mysqli_query($dbcon, $sql);
if ($result)
    echo "member 테이블 생성 완료<br>";
else
    echo "member 테이블 생성 실패<br>";

$sql = "CREATE TABLE `notice` (
    `notice_id` int NOT NULL AUTO_INCREMENT,
    `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `post_time` datetime NOT NULL,
    PRIMARY KEY (`notice_id`)
  ) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC";
$result = mysqli_query($dbcon, $sql);
if ($result)
    echo "notice 테이블 생성 완료<br><br>";
else
    echo "notice 테이블 생성 실패<br><br>";

echo "모든 작업이 완료되었습니다.";
?>