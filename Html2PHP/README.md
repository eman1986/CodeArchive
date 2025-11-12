# Html2PHP

## LEGAL

This code is provided AS-IS, and comes with NO support.
If you wish to improve the library, you are free to do so without my permission.
If you wish to give me credit, I welcome that but do not require it.

## INTRO

Html2PHP is a simple template engine that allows you to separate PHP from HTML.
This is meant to be a simple, but powerful template parser that gives you enough power to do what you need.

You can parse both static and dynamic content with this library and you also can do some minor MySQL parsing.
You also got minor decision making ability.

## EXAMPLE #1

Example 1 shows you the basics to the decision feature.

PHP:

```php
$tpl = new Html2PHP("home.htm");
$tpl->parseTags(array(
	"TITLE" => "$title",
	"LANG-WELCOME-GUEST" => "Welcome to my website Guest",
	"LANG-WELCOME-USER" => "Welcome to my website Member",
	"LANG-WELCOME-ADMIN" => "Welcome to my website Admin",
	"LANG-BODY" => "Enter some text here."));

#do some decision making.
if ($user == "guest") {
	$tpl->removeBlock("guest");
	$tpl->removeBlock("admin");
	$tpl->removeBlock("user");
} elseif($user == "member") {
	$tpl->removeBlock("admin");
	$tpl->removeBlock("guest");
} elseif ($user == "admin") {
	$tpl->removeBlock("guest");
	$tpl->removeBlock("user");
}

#output top template file.
echo $tpl->outputHtml();
```


HTML:
```html
<!-- START guest -->
{WELCOME-GUEST}<br />
<a href="login.php">login</a>
<!-- END guest -->

<!-- START user -->
{WELCOME-USER}<br />
<a href="ucp.php">User Settings</a>
<!-- END user -->

<!-- START admin -->
{WELCOME-ADMIN}<br />
<a href="ucp.php">User settings</a> - 
<a href="acp.php">Admin CP</a>
<!-- END admin -->

<hr />
{LANG-BODY}
```

## EXAMPLE #2

Example 2 shows you how to use the MySQL parsing.
Note the HTML code, the tags MUST look exactly as the field in the database table.


PHP:

```php
$q = mysql_query("SELECT Question FROM poll WHERE pollID='$pollID'");
$r = mysql_fetch_assoc($q);

//get poll options
$q2 = mysql_query("SELECT option_id, Poll_Option FROM poll WHERE pollID='$pollID'");
$pollResults = mysql_fetch_assoc($q2);

#call pollbox template file.
$tpl = new Html2PHP("pollbox.htm");

#setup tag code.
$tpl->parseTags(array(
	"QUESTION" => "$r[Question]"
));

#process poll options.
$tpl->replaceBlockTags("pollopt", $pollResults);

echo $tpl->outputHtml();
```

HTML:
```html
<form  method="post" action="vote.php">
	<table border="0" cellpadding="1" cellspacing="1">
		<tr>
			<td align="center">{QUESTION}</td>
		</tr>
		<!-- START pollopt -->
		<tr>
			<td align="center">
				<input type="radio" name="vote" value="{option_id}" />{Poll_Option}<br />
			</td>
		</tr>
		<!-- END pollopt -->
		<tr>
			<td align="center">
				<input type="submit" name="submit" value="Cast Vote" />
			</td>
		</tr>
	</table>
</form>
```