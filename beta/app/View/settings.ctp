<h1>Settings</h1>
<b>Current Settings</b> <br /> <br />

<table>
  <tr>
    <td>
      <b>Default World</b>
    </td>
    <td>
      <?php echo $this->Session->read('Auth.user.default_world') ? 'W' . $this->Session->read('Auth.user.default_world') : 'None'; ?>
    </td>
  </tr>
  <tr>
    <td>
      <b>Local Timezone</b>
    </td>
    <td>
      <?php echo $this->Session->read('Auth.user.local_timezone') ? $this->Session->read('Auth.user.local_timezone') : 'None'; ?>
    </td>
  </tr>
</table>

<br />

<b>Make Changes</b> <br /><br />
Set Default World:
<form action="settings/set_default_world" method="GET" style="display:inline">
  <select name="world">
  <option>W19</option>
  <option>W30</option>
  <option>W38</option>
  <option>W42</option>
  <option>W46</option>
  <option>W48</option>
  <option>W56</option>
  <option>W57</option>
  <option>W58</option>
  <option>W59</option>
  <option>W60</option>
  <option>W61</option>
  <option>W62</option>
  <option>W63</option>
  <option>W64</option>
  <option>W65</option>
  <option>W66</option>
  <option>W67</option>
  </select>
  <input type="submit" />
</form> <br />
Set Local Timezone:
<form action="scripts/setlocaltimezone.php" method="GET" style="display:inline">
  <select name="timezone">
    <option>GMT+1 (CET)</option>
    <option>GMT+2 (EET)</option>
    <option>GMT+3 (BT)</option>
    <option>GMT+4 (ZP4)</option>
    <option>GMT+5 (ZP5)</option>
    <option>GMT+5:30 (IST)</option>
    <option>GMT+6 (ZP6)</option>
    <option>GMT+7 (CXT)</option>
    <option>GMT+8 (AWST)</option>
    <option>GMT+9 (JSP)</option>
    <option>GMT+10 (EAST)</option>
    <option>GMT+11</option>
    <option>GMT+12 (NZST)</option>
    <option>GMT-1 (WAT)</option>
    <option>GMT-2 (AT)</option>
    <option>GMT-3</option>
    <option>GMT-4 (AST)</option>
    <option>GMT-5 (EST)</option>
    <option>GMT-6 (CST)</option>
    <option>GMT-7 (MST)</option>
    <option>GMT-8 (PST)</option>
    <option>GMT-9 (AKST)</option>
    <option>GMT-10 (HST)</option>
    <option>GMT-11 (NT)</option>
  </select>
  <input type="submit" />
</form>