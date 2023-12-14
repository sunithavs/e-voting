<?php
	session_start();
    include('header.php');
	if(!isset($_SESSION['user_id'])){
		session_destroy();
		header("location:index.php");
	}
    include('menubar.php');
 if(!isset($_SESSION["voted"]))
   {

	?>
<div ng-app="voting-app" ng-controller="VotingController">
<div ng-show="voting_form">
		<form>			
			<h1>Electronic Voting System</h1><br>
			<table class="table table-stripe" >
			<thead><tr> 
			<th>Sl.no</th>
			<th>Candidate Name</th>
			<th>Candidate Code</th>
			<th> Button </th>
			</tr></thead>
			<tbody>
			<tr ng-repeat="candidate in candidates">
			<td> {{$index + 1}}</td>
			<td> {{ candidate.name }} </td>
			<td> {{candidate.code }} </td>
			<td><md-button class="btn1" ng-click="confirmationDialog(candidate.id,candidate.name,candidate.code)"> Vote </md-button></td>
			</tr>
			</tbody>
			</table>			
		</form>
	</div>
	<div id="confirmation-dialog">
		<div class="modal fade confirmation-dialog" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Voting Confirmation</h4>
					</div>
					<div class="modal-body">
						<div class="span5">{{confirmationDialogConfig.message}}<b>{{confirmationDialogConfig.parameter}}</b></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<button ng-click="executeVotingAction(confirmationDialogConfig.id)" class="btn btn-primary">Cofirm</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div ng-show="success_form">
		<div class="panel-body">
		<h1>Thanks for voting</h1>
		</div>
	</div>
</div>
<?php
   }
   else{
	?>
	<div class="panel panel-default">
    <div class="panel-heading">
     <!-- <h3 class="panel-title">Welcome to system</h3> -->
    </div>
	<div>
		<div class="panel-body">
		<h1>You are already voted. Thanks for visiting e-voting system</h1>
		</div>
	</div>
	<?php
   }
   include('footer.php');
?>
<script>
	var fetch = angular.module('voting-app', []);
	fetch.controller('VotingController', ['$scope', '$http','$window', function ($scope, $http,$window) {
	$scope.voting_form = true;
	$http({
	method: 'get',
	url: 'getCandidates.php'
	}).then(function successCallback(response) {
	$scope.candidates = response.data;
	});
	$scope.confirmationDialogConfig = {};
	$scope.confirmationDialog = function(id,name,code) {
		$scope.confirmationDialogConfig = {
		title: "Caution!!!",
		message: "Are you sure you want to vote for ",
		parameter :name+"("+code+")?",
		id : id,
		buttons: [{
			label: "Delete",
			action: "delete"
		}]
		};
		$scope.showDialog(true);
	};
	$scope.executeVotingAction = function(id){
		$http({
		method:"POST",
		url:"voting.php",
		data:{'id':id}
		}).success(function(data){
		$scope.alertMsg = true;
		if(data.error != '')
		{
			$scope.alertClass = 'alert-danger';
			$scope.alertMessage = data.error;
		}
		else
		{
			$scope.showDialog(false);
			$scope.voting_form = false;
	  		$scope.success_form = true;
		}
		});
	};
	$scope.showDialog = function(flag) {
		jQuery("#confirmation-dialog .modal").modal(flag ? 'show' : 'hide');
	};
    }]);
</script>
