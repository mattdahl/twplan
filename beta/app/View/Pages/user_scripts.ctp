<div ng-controller="UserScriptsController">
  <h1>User Scripts</h1>
  <p>Below are helpful scripts to install in your Tribalwars quickbar that enhance TWplan's usability.</p>

  <h2>Launch Script</h2>
  <p>When you click the Launch link that TWplan displays next to each command in your generated plan, you are directed to a special Tribalwars URL. Once at the rally point, use this script to automatically populate the troops fields with the appropriate troop combinations you define below, depending on what kind of attack it is (nuke, noble, or support).</p>

  <p><b>Troop Amounts</b></p>
  <table id="troop_amounts">
    <tr>
      <td></td>
      <td><img src="http://static-twplan.appspot.com/images/units/spear.png" /></td>
      <td><img src="http://static-twplan.appspot.com/images/units/sword.png" /></td>
      <td><img src="http://static-twplan.appspot.com/images/units/axe.png" /></td>
      <td><img src="http://static-twplan.appspot.com/images/units/archer.png" /></td>
      <td><img src="http://static-twplan.appspot.com/images/units/scout.png" /></td>
      <td><img src="http://static-twplan.appspot.com/images/units/lc.png" /></td>
      <td><img src="http://static-twplan.appspot.com/images/units/hc.png" /></td>
      <td><img src="http://static-twplan.appspot.com/images/units/marcher.png" /></td>
      <td><img src="http://static-twplan.appspot.com/images/units/ram.png" /></td>
      <td><img src="http://static-twplan.appspot.com/images/units/cat.png" /></td>
      <td><img src="http://static-twplan.appspot.com/images/units/pally.png" /></td>
      <td><img src="http://static-twplan.appspot.com/images/units/noble.png" /></td>
    </tr>
    <tr>
      <td><b>Nuke</b></td>
      <td><input type="number" ng-model="launch_script.nuke_troops.spear" /></td>
      <td><input type="number" ng-model="launch_script.nuke_troops.sword" /></td>
      <td><input type="number" ng-model="launch_script.nuke_troops.axe" /></td>
      <td><input type="number" ng-model="launch_script.nuke_troops.archer" /></td>
      <td><input type="number" ng-model="launch_script.nuke_troops.scout" /></td>
      <td><input type="number" ng-model="launch_script.nuke_troops.lc" /></td>
      <td><input type="number" ng-model="launch_script.nuke_troops.hc" /></td>
      <td><input type="number" ng-model="launch_script.nuke_troops.marcher" /></td>
      <td><input type="number" ng-model="launch_script.nuke_troops.ram" /></td>
      <td><input type="number" ng-model="launch_script.nuke_troops.cat" /></td>
      <td><input type="number" ng-model="launch_script.nuke_troops.pally" /></td>
      <td><input type="number" ng-model="launch_script.nuke_troops.noble" /></td>
    </tr>
    <tr>
      <td><b>Noble</b></td>
      <td><input type="number" ng-model="launch_script.noble_troops.spear" /></td>
      <td><input type="number" ng-model="launch_script.noble_troops.sword" /></td>
      <td><input type="number" ng-model="launch_script.noble_troops.axe" /></td>
      <td><input type="number" ng-model="launch_script.noble_troops.archer" /></td>
      <td><input type="number" ng-model="launch_script.noble_troops.scout" /></td>
      <td><input type="number" ng-model="launch_script.noble_troops.lc" /></td>
      <td><input type="number" ng-model="launch_script.noble_troops.hc" /></td>
      <td><input type="number" ng-model="launch_script.noble_troops.marcher" /></td>
      <td><input type="number" ng-model="launch_script.noble_troops.ram" /></td>
      <td><input type="number" ng-model="launch_script.noble_troops.cat" /></td>
      <td><input type="number" ng-model="launch_script.noble_troops.pally" /></td>
      <td><input type="number" ng-model="launch_script.noble_troops.noble" /></td>
    </tr>
    <tr>
      <td><b>Support</b></td>
      <td><input type="number" ng-model="launch_script.support_troops.spear" /></td>
      <td><input type="number" ng-model="launch_script.support_troops.sword" /></td>
      <td><input type="number" ng-model="launch_script.support_troops.axe" /></td>
      <td><input type="number" ng-model="launch_script.support_troops.archer" /></td>
      <td><input type="number" ng-model="launch_script.support_troops.scout" /></td>
      <td><input type="number" ng-model="launch_script.support_troops.lc" /></td>
      <td><input type="number" ng-model="launch_script.support_troops.hc" /></td>
      <td><input type="number" ng-model="launch_script.support_troops.marcher" /></td>
      <td><input type="number" ng-model="launch_script.support_troops.ram" /></td>
      <td><input type="number" ng-model="launch_script.support_troops.cat" /></td>
      <td><input type="number" ng-model="launch_script.support_troops.pally" /></td>
      <td><input type="number" ng-model="launch_script.support_troops.noble" /></td>
    </tr>
  </table>

  <p><b>Archer World</b>&nbsp<input type="checkbox" ng-model="is_archer" ng-checked="is_archer" /></p>

  <p><b>Script</b></p>
  <pre class="user_script" ng-click="select_all($event.target)">
    javascript:
    var troops = {
      nuke: [
        {{ launch_script.nuke_troops.spear }},
        {{ launch_script.nuke_troops.sword }},
        {{ launch_script.nuke_troops.axe }},
        {{ launch_script.nuke_troops.archer }},
        {{ launch_script.nuke_troops.scout }},
        {{ launch_script.nuke_troops.lc }},
        {{ launch_script.nuke_troops.hc }},
        {{ launch_script.nuke_troops.marcher }},
        {{ launch_script.nuke_troops.ram }},
        {{ launch_script.nuke_troops.cat }},
        {{ launch_script.nuke_troops.pally }},
        {{ launch_script.nuke_troops.noble }}
      ],
      noble: [
        {{ launch_script.noble_troops.spear }},
        {{ launch_script.noble_troops.sword }},
        {{ launch_script.noble_troops.axe }},
        {{ launch_script.noble_troops.archer }},
        {{ launch_script.noble_troops.scout }},
        {{ launch_script.noble_troops.lc }},
        {{ launch_script.noble_troops.hc }},
        {{ launch_script.noble_troops.marcher }},
        {{ launch_script.noble_troops.ram }},
        {{ launch_script.noble_troops.cat }},
        {{ launch_script.noble_troops.pally }},
        {{ launch_script.noble_troops.noble }}
      ],
      support: [
        {{ launch_script.support_troops.spear }},
        {{ launch_script.support_troops.sword }},
        {{ launch_script.support_troops.axe }},
        {{ launch_script.support_troops.archer }},
        {{ launch_script.support_troops.scout }},
        {{ launch_script.support_troops.lc }},
        {{ launch_script.support_troops.hc }},
        {{ launch_script.support_troops.marcher }},
        {{ launch_script.support_troops.ram }},
        {{ launch_script.support_troops.cat }},
        {{ launch_script.support_troops.pally }},
        {{ launch_script.support_troops.noble }}
      ],
    };
    $.getScript('{{ launch_script.external_url }}');
    void(0);
  </pre>

  <h2>Group Import Script</h2>
  <p>Using this script you can easily import your existing Tribalwars village groups into TWplan for one-click use in your plans. Run this script from the Groups Overview page in Tribalwars. (Requires premium account.)</p>

  <p><b>Script</b></p>
  <pre class="user_script" ng-click="select_all($event.target)">
    coming soon
  </pre>
</div>