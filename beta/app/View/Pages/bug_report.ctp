<div ng-controller="BugReportController">
	<h1>Bug Report</h1>
	<p>Something go wrong? Report your problem here. TWplan is still in beta, so not everything is working perfectly yet.</p>
	<p>If you need urgent assistance, you can reach Syntex (Matt) directly via email at <a href="mailto:matt@twplan.com">matt@twplan.com</a> or via Skype at <i>syntexgrid</i>.</p>

	<hr />

	<p>
		<b>What went wrong?</b> <br />
		<textarea class="bug_report_item" ng-model="bug_report.description"></textarea>
	</p>

	<p>
		<b>What page (or planing step) were you using?</b> <br />
		<textarea class="bug_report_item" ng-model="bug_report.page"></textarea>
	</p>

	<p>
		<b>Was there an error message?</b> <br />
		<textarea class="bug_report_item" ng-model="bug_report.error_message"></textarea>
	</p>

	<p>
		<b>Were you able to replicate the problem?</b> <br />
		<textarea class="bug_report_item" ng-model="bug_report.is_replicable"></textarea>
	</p>

	<p>
		<b>Any contact information, if you want to help more. :)</b> <br />
		<textarea class="bug_report_item" ng-model="bug_report.contact_information"></textarea>
	</p>

	<input type="button" value="Submit" ng-click="submit_bug_report()">

	<p>Thanks for your help! Sorry for any inconvenience.</p>
</div>