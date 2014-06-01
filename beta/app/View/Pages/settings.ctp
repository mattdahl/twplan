<div ng-controller="SettingsController">
  <h1>Settings</h1>

  <table>
    <tr>
      <td>
        <b>Default World</b>
      </td>
      <td>
        <select ng-model="default_world" ng-options="'W' + w.world group by w.server for w in worlds" ng-change="change_default_world()"></select>
      </td>
    </tr>
    <tr>
      <td>
        <b>Local Timezone</b>
      </td>
      <td>
        <select ng-model="local_timezone" ng-options="t.name for t in timezones" ng-change="change_local_timezone()"></select>
      </td>
    </tr>
  </table>
</div>