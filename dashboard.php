<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8"/>
		<title>e-voting system</title>

		<link href="http://fonts.googleapis.com/css?family=Cookie|Open+Sans:400,700" rel="stylesheet" />

		<!-- The main CSS file -->
		<link href="style.css" rel="stylesheet" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

		<!-- JS includes -->
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.0.7/angular.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div ng-app="voting-app" ng-controller="VotingController">
		<div class="panel panel-default" ng-show="voting_form">
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
				<!-- <td> <button ng-click="postvote(candidate.id)">Vote</button></td> -->
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
		</div>
		<div class="panel panel-default" ng-show="success-form">
			<div class="panel-body">
			<h1>Thanks for voting</h1>
			</div>
		</div>
		
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

	  

	  $scope.postVote = function(candidateId){
			alert("Candidate Id is "+candidateId);
		};
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
	</body>
</html>
