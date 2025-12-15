<?php
/*
    The Hypnotize Project is a Content Management System (CMS) that allows you to easily make your own webpage.

    Copyright (C) 2004-2025  Hypnotize

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.

    https://www.github.com/frebergguru/THP-Revamped
*/
print '<div class="flex-table">

<div class="flex-header">
<font face="Arial" size=2>
<strong>S&oslash;k</strong>
</font>
</div>
<div class="flex-content under">
<form action="'.$_SERVER["PHP_SELF"].'?site='."$site".'&amp;style='."$style".'" method="post">
<input type="text" name="search" size="30"><br>
<br>
<input type="submit" value="S&oslash;k"> || <input type="reset" value="Nullstill">
</form>
</div>


</div>


<br>';
?>
