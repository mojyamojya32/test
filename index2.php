<?php
	session_start();
	
	if ($_SESSION != null) {
		$category = $_SESSION['category'];
		$title = $_SESSION['title'];
		$email = $_SESSION['email'];
		$description = $_SESSION['description'];
		
		switch ($category) {
			case "iPhone/iPadアプリケーション開発の見積もりについて":
				$selected1 = " selected='selected'";
				break;
			case "Androidアプリケーション開発の見積もりについて":
				$selected2 = " selected='selsected'";
				break;
			case "リッチインターネットアプリケーション（AIR、Flex、flash）開発の見積もりについて":
				$selected3 = " selected='selected'";
				break;
			case "Webアプリケーション開発の見積もりについて":
				$selected4 = " selected='selected'";
				break;
			case "サーバ保守・運用（Amazon EC2、Cent OS）":
				$selected5 = " selected='selected'";
				break;
			case "当サイトについて":
				$selected6 = "selected='selecetd'";
				break;
			case "その他":
				$selected7 = "selected='selected'";
				break;
		}
	}
	
	$valid = true;
	
	if ($_POST['submit'] != null) {
		$category = $_POST['category'];
		$title = $_POST['title'];
		$email = $_POST['email'];
		$description = $_POST['description'];
		
		// エラーチェック
		// 分類
		if ($category == "（選択してください）") {
			$valid = false;
			$message1 = "<br /><span class='warning'>お問い合わせの分類を選択してください。</span>";
			$selected1 = $selected2 = $selected3 = $selected4 = $selected5 = $selected6 = $selected7 = "";
		}
		// タイトル
		if ($title == "") {
			$valid = false;
			$message2 = "<br /><span class='warning'>タイトルを入力してください。</span>";
		}
		// メールアドレス
		if ($email == "") {
			$valid = false;
			$message3 = "<br /><span class='warning'>メールアドレスを入力してください。</span>";
		}
		else {
			if (!preg_match("/^[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[a-z]{2,4}|museum|travel)$/i", $email)) {
				$valid = false;
				$message3 = "<br /><span class='warning'>正しいメールアドレスを入力しえください。</span>";
			}
		}
		// 問い合わせ内容
		if ($description == "") {
			$valid = false;
			$message4 = "<br /><span class='warning'>メールアドレスを入力してください。</span>";
		}
		
		$_SESSION['category'] = $category;
		$_SESSION['title'] = $title;
		$_SESSION['email'] = $email;
		$_SESSION['description'] = $description;
	}
	else if ($_POST['send'] != null) {
		$session = false;
		
		if ($_SESSION != null) {
			$session = true;

			$category = $_SESSION['category'];
			$title = $_SESSION['titile'];
			$email = $_SESSION['email'];
			$description = $_SESSION['description'];

			mb_language("Japanese");
			mb_internal_encoding("UTF-8");
			
			$body = $category . "についてのお問い合わせがありました。" . "\n\n" . $description;
			
			$result = mb_send_mail("asato@live-cast.asia", $titel, $body, "From: " . $email);
			
			session_destroy();
		}
	}
?>
     <div id="content">
<?php if ($_POST == null || $_POST['back'] != null || !$valid): ?>
        <div id="summary">
             <h1>お問い合わせ</h1>
             <p>当コミュニティではシステム開発を承っております。お気軽にご相談ください。</p>
             <p>また、システム開発以外の質問もお受けしております。こちらのお問い合わせフォームからどうぞ。</p>
        </div>
        <div id="contact">
            <form action="./" method="post">
                <div class="item">
                    <div class="label">
                        <span>お問い合わせの分類</span><span class="required">（必須）</span>
                        <?php echo $message1; ?>
                    </div>
                    <select id="category" name="category">
                        <option>（選択してください）</option>
                        <option<?php echo $selected1 ?>>iPhone/iPadアプリケーション開発の見積もりについて</option>
                        <option<?php echo $selected2 ?>>Androidアプリケーション開発の見積もりについて</option>
                        <option<?php echo $selected3 ?>>リッチインターネットアプリケーション（AIR、Flex、flash）開発の見積もりについて</option>
                        <option<?php echo $selected4 ?>>Webアプリケーション開発の見積もりについて</option>
                        <option<?php echo $selected5 ?>>サーバ保守・運用（Amazon EC2、Cent OS）</option>
                        <option<?php echo $selected6 ?>>当サイトについて</option>
                        <option<?php echo $selected7 ?>>その他</option>
                    </select>
                    <div class="clear"></div>
                </div>
                <div class="item">
                    <div class="label">
                        <span>タイトル</span><span class="required">（必須）</span>
                        <?php echo $message2; ?>
                    </div>
                    <input type="text" name="title" value="<?php echo $title; ?>" />
                    <div class="clear"></div>
                </div>
                <div class="item">
                    <div class="label">
                        <span>メールアドレス</span><span class="required">（必須）</span>
                        <?php echo $message3; ?>
                    </div>
                    <input type="text" name="email" value="<?php echo $email; ?>" />
                    <div class="clear"></div>
                </div>
                <div class="item">
                    <div class="label">
                        <span>お問い合わせ内容</span><span class="required">（必須）</span>
                        <?php echo $message4; ?>
                    </div>
                    <textarea id="description" rows="10" cols="50" name="description"><?php echo $description; ?></textarea>
                    <div class="clear"></div>
                </div>
                <div id="bottom">
                    <input type="submit" name="submit" value="送信" />
                </div>
             </form>
        </div>
<?php elseif ($_POST['submit'] != null): ?>
        <div id="summary">
             <h1>お問い合わせ内容確認</h1>
             <p>お問い合わせ内容を確認してください。</p>
             <p>よろしければ送信ボタンをクリックしてください。</p>
        </div>
        <div id="contact">
             <form action="./" method="post">
                 <div class="item">
                     <div class="label">
                         <span>お問い合わせの分類</span>
                     </div>
                     <div class="data">
                         <span><?php echo $category; ?></span>
                     </div>
                 </div>
                 <div class="item">
                     <div class="label">
                         <span>タイトル</span>
                     </div>
                     <div class="data">
                         <span><?php echo $title; ?></span>
                     </div>
                 </div>
                 <div class="item">
                     <div class="label">
                         <span>メールアドレス</span>
                     </div>
                     <div class="data">
                         <span><?php echo $email; ?></span>
                     </div>
                 </div>
                 <div class="item">
                     <div class="label">
                         <span>お問い合わせ内容</span>
                     </div>
                     <div class="data">
                         <span><?php echo $description; ?></span>
                     </div>
                 </div>
                 <div id="bottom">
                     <input type="submit" name="back" value="戻る" />
                     <input type="submit" name="send" value="送信" />
                 </div>
             </form>
         </div>
<?php elseif ($_POST['send'] != null): ?>
	<?php if ($session): ?>
		<?php if ($result): ?>
        <div id="summary">
             <h1>送信完了</h1>
             <p>お問い合わせありがとうございました。</p>
             <p>おってご連絡いたします。</p>
        </div>
		<?php else: ?>
        <div id="summary">
             <h1>送信エラー</h1>
             <p>お問い合わせの送信ができませんでした。</p>
             <p>大変おそれいりますが、こちらよりメールにてお問い合わせください。</p>
        </div>
		<?php endif; ?>
	<?php else: ?>
        <div id="summary">
             <h1>エラー</h1>
             <p>エラーが発生しました。</p>
             <p>お問い合わせは既に送信済か、タイムアウトしました。</p>
        </div>
	<?php endif; ?>
<?php endif; ?>
     </div>
</div>
