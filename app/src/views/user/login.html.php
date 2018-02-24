{extends file="base.html"}
		
{block name=title}Login page{/block}
{block name="main-content"}

<form class="login" method="post">
	<fieldset>
		<legend>Sign in</legend>
		<p class="message">{$message}</p>
		<p>{$hi}</p>
		<div class="username">
			<label>Username</label>
			<input name="username" placeholder="Username" value="{$username}"/>
		</div>
		<div class="password">
			<label>Password</label>
			<input name="password" placeholder="Password"/>
		</div>
		<button type="submit">Enter</button>
	</fieldset>
</form>
{/block}
