<div id="welcome" ng-controller="WelcomeController">
  Welcome
    <span id="username" ng-bind="username"></span>
  | World:
    <select ng-model="current_world" ng-options="'W' + w for w in worlds" ng-change="change_world()"></select>
    <br />
    <span id="lastupdatetext">Last updated <span ng-bind="last_updated"></span>h ago.</span>
</div>