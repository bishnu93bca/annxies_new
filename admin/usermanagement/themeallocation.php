<?php
if($editid!='')
{
	$obj = new MyAccount();
	$selData = $obj->getAccountDetailsByuserId($editid);
	if($selData)
	{
		$username = $selData['username'];
		$password = $selData['orgPassword'];
		$fullname = $selData['fullname'];
		$email = $selData['email'];
		$address = $selData['address'];
		$phone = $selData['phone'];
		$siteId = $selData['siteId'];
		$siteName = $selData['siteName'];
		$siteUrl = $selData['siteUrl'];
		$siteEmail = $selData['siteEmail'];
		$sitePhone = $selData['sitePhone'];
		$sitePaypalEmail = $selData['sitePaypalEmail'];
		$siteCurrency = $selData['siteCurrency'];
		$sitePaypalSuccessPath = $selData['sitePaypalSuccessPath'];
		$sitePaypalCancelPath = $selData['sitePaypalCancelPath'];
		
		$sitePath = $selData['sitePath'];
		$location = $selData['location'];
		$googleAnalytics = $selData['googleAnalytics'];
		$googleVerification = $selData['googleVerification'];
		$metaDistribution = $selData['metaDistribution'];
		$metaClassification = $selData['metaClassification'];
		$metaCopyright = $selData['metaCopyright'];
		$metaLanguage = $selData['metaLanguage'];
		$metaAuthor = $selData['metaAuthor'];
		$metaRobots = $selData['metaRobots'];
		$metaGenerator = $selData['metaGenerator'];
		
		$access_add = $selData['access_add'];
		$access_edit = $selData['access_edit'];
		$access_delete = $selData['access_delete'];
		$themes = $selData['themes'];
		$themeId = $selData['themeId']; 		
		
		$userpermission_array = split(',',$selData['permission']);		
	}
}
?>
<div class="iconbox">
	<span style="float:left; width:48px; margin:0px 15px 0px 0px;"><img src="images/user.png" alt="User" title="User" height="39" /></span>
	<h2 style="float:left; margin:0px; padding:10px 0px 0px 0px; font-size:14px; color:#0066FF;">
		<?php if($editid) echo 'Edit User :: '.$username; else echo 'Add User';?> >> STEP - III
	</h2>
</div>

<form name="modifycontent" action="" method="post">

	<div class="iconbox">
	<?php
	$obj = new UserClass();
	$tobj = new Theme();									
	
	if($editid!='')
	{					
		//$selData = $obj->user_by_id($editid,$Link);
		$themesAssigned = explode('#',$themes);
		if($selData['themes'])
		{		
		?>
		<p class="subHeadiing">Change Theme</p>
		
		<p class="subHeadiing">
			<select name="themeId" size="5">
				<?php
				for($i=0;$i<sizeof($themesAssigned);$i++)
				{
					$tData = $tobj->themeBythemeId($themesAssigned[$i],$Link);									
					
					if($themeId==$tData['themeId'])									
					echo '<option value="'.$themesAssigned[$i].'" selected>'.$tData['themeName'].'</option>';
					else
					echo '<option value="'.$themesAssigned[$i].'">'.$tData['themeName'].'</option>';
				}
				?>								
			</select>
		</p>			
	<?php
		}
	}				
	?>
	</div>

	<div class="iconbox">	
	
		<p class="subHeadiing">Allocate Compatible Themes</p>
	
		<?php	
		
		$selData = $tobj->getThemes($Link);
					
		if($selData)
		{	
			for($i=0;$i<sizeof($selData);$i++)
			{		
			?>				
				
			<div class="iconbox-thum">
			
				<div class="iconbox-thum-img"><a href="../<?php echo $selData[$i]['themeLocation'];?>/preview.jpg" class="preview"><img src="../<?php echo $selData[$i]['themeLocation'];?>/thumb.jpg" width="120" height="95" /></a></div>
				
				<div class="icon-text">
				
					<?php 
					if($editid!='')	
					{					
						$themesArray = explode('#',$themes);
						
						if(in_array($selData[$i]['themeId'],$themesArray))
							$checked = 'checked';
						else
							$checked = '';
					}
					
					echo '<input type="checkbox" name="allocatedthemeId[]" '.$checked.' value="'.$selData[$i]['themeId'].'" />';
					echo $selData[$i]['themeName'];
					echo '<br />';
					?>	
											
				</div>
				
			</div>
							
			<?php
			}
		}
		?>
	
	</div>
	
	<div class="iconbox">
				
	<p class="description-line1">
		<span class="save_button-box">
			<input name="IdToEdit" type="hidden" value="<?php echo $editid;?>" />
			<input name="siteId" type="hidden" value="<?php echo $siteId;?>" />
			<input name="userId" type="hidden" value="<?php echo $userId;?>" />
			<input name="SourceForm" type="hidden" value="ThemeAllocation" />				
			<input name="Back" type="button" onclick="history.back(-1);" class="save_button" value="Back" />
			<input name="Save" type="submit" class="save_button" value="Save" />
			<input name="Cancel" type="button"  onclick="location.href='index.php?pageType=<?php echo $pageType;?>'" class="save_button" value="Close" />
		</span>
	</p>

	</div>
	
</form>