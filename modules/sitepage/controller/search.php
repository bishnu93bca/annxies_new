<fieldset>
<?php
if(!$search)
$search = 'Enter Search Text';
if(!$searchcat)
$searchcat = '-1';
?>
<table width="100%">
	<tr>
	  <td width="6%"><img src="images/search.png" alt="Search"/></td>
	  <td width="14%"><input type="text" name="search" onBlur="if(this.value==''){this.value='Enter Search Text'};" onFocus="if(this.value=='Enter Search Text'){this.value=''};" value="<?php echo $search; ?>"/></td>
	  <td width="10%"><select name="searchcat" id="searchcat">
	    <option value="-1">Search By</option>
	    <option value="categoryName" <?php if($searchcat =='categoryName') echo 'selected="selected"' ?>>Category</option>
	    <option value="categoryDescription" <?php if($searchcat =='categoryDescription') echo 'selected="selected"' ?>>Description</option>
	    </select>
	  </td>
	  <td width="57%"><input name="SearchForm" type="submit" class="searchbtn" value="Search" /></td>
	  <td width="13%" align="right">
		<table width="100%">
			<tr>
				<td>Status:</td>
				<td><select name="status" onChange="myForm.submit()">
						<option value="">All</option>
						<option value="Y" <?php if($status=='Y') echo 'selected' ?>>Active</option>
						<option value="N" <?php if($status=='N') echo 'selected' ?>>Inactive</option>
					</select>				</td>
			</tr>
		</table>	  </td>
	</tr>
</table>
</fieldset>