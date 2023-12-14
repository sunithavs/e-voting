<?php
session_start();
include('header.php');
if(!isset($_SESSION["admin_id"])){
        session_destroy();
        header("location:index.php");
}
?>
<div id="main" ng-app="admin-app" ng-controller="AdminController">
        <nav>
        <div class="account-item" ng-repeat='item in menuItems'>
                <div class="account-heading" ng-class="{'active' : activeMenu == 'item'}">
                <h4 class="account-title">
                        <a href="#/Messages" ng-click="setActive(item)"> {{ item }}</a>
                        
                </h4>
                </div>
        </div>
        <a class="logout" href="logout.php">Log out</a>
        </nav>
        <div ng-show="voters_form">	
                <form>	
			<h1>Voters List</h1><br>
			<table class="table table-stripe" >
			<thead><tr> 
			<th>Sl.no</th>
			<th>Voter Name</th>
			<th>Voter email</th>
			<th> Voting Status </th>
			</tr></thead>
			<tbody>
			<tr ng-repeat="voter in voters">
			<td> {{$index + 1}}</td>
			<td> {{ voter.name }} </td>
			<td> {{voter.email }} </td>
			<td>{{voter.status}}</td>
                        </td>
			</tr>
			</tbody>
			</table>
                        </form>
	</div>
        <div ng-show="candidates_form">	
                <form>	
			<h1>Electronic Voting System</h1><br>
			<table class="table table-stripe" >
			<thead><tr> 
			<th>Sl.no</th>
			<th>Candidate Name</th>
			<th>Candidate Code</th>
			</tr></thead>
			<tbody>
			<tr ng-repeat="candidate in candidates">
			<td> {{$index + 1}}</td>
			<td> {{ candidate.name }} </td>
			<td> {{candidate.code }} </td>
			</tr>
			</tbody>
			</table>			
		</form>
	</div>
        <div ng-show="index_form">
                <div class="panel panel-default">
                        <div class="panel-heading">
                        </div>
                        <div class="panel-body">
                        <h1>Welcome to e-voting admin system</h1>
                        </div>
                </div>
        </div>
        <div ng-show="vote_results_form">	
                <form>	
			<h1>Electronic Voting System</h1><br>
			<table class="table table-stripe" >
			<thead><tr> 
			<th>Sl.no</th>
			<th>Candidate Name</th>
			<th>No.of Votes</th>
			</tr></thead>
			<tbody>
			<tr ng-repeat="vote in votes">
			<td> {{$index + 1}}</td>
			<td> {{ vote.name }} ({{vote.code }})</td>
			<td> {{vote.votes }} </td>
			</tr>
			</tbody>
			</table>			
		</form>
	</div>

<script>
	var fetch = angular.module('admin-app', []);
	fetch.controller('AdminController', ['$scope', '$http','$window', function ($scope, $http,$window) {
                $scope.index_form = true;
                $scope.menuItems = ['Dashboard','Voters List', 'Candidate List', 'Voting Results'];
                $scope.activeMenu = $scope.menuItems[0];
                $scope.setActive = function(menuItem) {
                   $scope.activeMenu = menuItem;
                   if(menuItem == 'Voters List'){
                        $http({
                                method: 'get',
                                url: 'getvoterslist.php'
                                }).then(function successCallback(response) {
                                $scope.voters_form = true;
                                $scope.candidates_form = false;
                                $scope.index_form = false;
                                $scope.voters = response.data;
                                });
                  }
                  if(menuItem == 'Candidate List'){
                        $http({
                                method: 'get',
                                url: '../getcandidates.php'
                                }).then(function successCallback(response) {
                                $scope.candidates_form = true;
                                $scope.voters_form = false;
                                $scope.index_form = false;
                                $scope.candidates = response.data;
                                });
                  }
                  if(menuItem == 'Dashboard'){
                        $scope.candidates_form = false;
                        $scope.voters_form = false;
                        $scope.index_form = true;
                  }
                  if(menuItem == 'Voting Results'){
                        $scope.candidates_form = false;
                        $scope.voters_form = false;
                        $scope.index_form = false;
                        $http({
                                method: 'get',
                                url: 'voting_results.php'
                                }).then(function successCallback(response) {
                                $scope.candidates_form = false;
                                $scope.voters_form = false;
                                $scope.index_form = false;
                                $scope.vote_results_form = true;
                                $scope.votes = response.data;
                                });
                  }
                };
        }]);
</script>