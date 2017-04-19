@push('head')
<script type="text/ng-template" id="slide.html">
    <div ng-controller="SlideCtrl">
        <div class="container-fluid">
            <div vns-table="tableParams"></div>
        </div>
        <div class="content-btn">
            <button ng-disabled="isLoading" class="btn btn-default btn-sm" ng-click="tableParams.reload()"><i class="fa fa-refresh fa-fw"></i> {{ __('Reload') }}</button>
            <button class="btn btn-success btn-sm" ng-click="new()"><i class="fa fa-file-o fa-fw"></i> {{ __('New slide') }}</button>
        </div>
    </div>
</script>
<script type="text/ng-template" id="slide/edit.html">
    <div class="modal-header">
        <h4 class="modal-title">{{__('Edit slide')}}: @{{name}}</h4>
    </div>
    <div class="modal-body">
        <table class="table table-striped table-bordered" style="margin-bottom: 0">
            <colgroup>
                <col width="25%">
                <col>
            </colgroup>
            <tbody>
            <tr>
                <td >{{ __('Name') }}</td>
                <td>
                    <input class="form-control" type="text" ng-model="slide.name">
                </td>
            </tr>
            <tr>
                <td >{{ __('Slug') }}</td>
                <td>
                    <input class="form-control" type="text" ng-model="slide.slug">
                </td>
            </tr>
            <tr>
                <td >{{ __('Image') }}</td>
                <td>
                    <vns-media-input ng-model="slide.image" media-config="{single:true}"/>
                </td>
            </tr>
            <tr>
                <td >{{ __('Status') }}</td>
                <td>
                    <div class="btn-group">
                        <label class="btn btn-default" ng-model="slide.status" uib-btn-radio="true">{{__('Enabled')}}</label>
                        <label class="btn btn-default" ng-model="slide.status" uib-btn-radio="false">{{__('Disabled')}}</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td >{{ __('Description') }}</td>
                <td>
                    <textarea ui-tinymce="$root.tinymceOptions" ng-model="slide.description"></textarea>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" ng-click="save()" >{{ __('Save') }}</button>
        <button type="button" class="btn btn-primary" ng-click="close()" >{{ __('Close') }}</button>
    </div>
</script>
<script type="text/ng-template" id="slide/new.html">
    <div class="modal-header">
        <h4 class="modal-title">{{__('New slide')}}</h4>
    </div>
    <div class="modal-body">
        <table class="table table-striped table-bordered" style="margin-bottom: 0">
            <colgroup>
                <col width="25%">
                <col>
            </colgroup>
            <tbody>
            <tr>
                <td >{{ __('Name') }}</td>
                <td>
                    <input class="form-control" type="text" ng-model="slide.name">
                </td>
            </tr>
            <tr>
                <td >{{ __('Url') }}</td>
                <td>
                    <input class="form-control" type="text" ng-model="slide.slug">
                </td>
            </tr>
            <tr>
                <td >{{ __('Image') }}</td>
                <td>
                    <vns-media-input ng-model="slide.image" media-config="{single:true}"/>
                </td>
            </tr>
            <tr>
                <td >{{ __('Status') }}</td>
                <td>
                    <div class="btn-group">
                        <label class="btn btn-default" ng-model="slide.status" uib-btn-radio="true">{{__('Enabled')}}</label>
                        <label class="btn btn-default" ng-model="slide.status" uib-btn-radio="false">{{__('Disabled')}}</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td >{{ __('Description') }}</td>
                <td>
                    <textarea ui-tinymce="$root.tinymceOptions" ng-model="slide.description"></textarea>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" ng-click="save()" >{{ __('Save') }}</button>
        <button type="button" class="btn btn-primary" ng-click="close()" >{{ __('Close') }}</button>
    </div>
</script>
<script type="text/javascript">
    VnSapp.controller('SlideCtrl', function ($rootScope, $scope, $uibModal, $resource, $http, $filter, vnsTableParams, Dialog, Notification) {
        $rootScope.siteTitle = '{{__('Slide')}}';

        var Slide = $resource(API_URL + '/slide/:id', {id: '@id'}, {
            update: {
                method: 'PUT'
            }
        });

        var tableParams = $scope.tableParams = new vnsTableParams({
            columns: {
                id: {
                    label: '{{__('Id')}}',
                    type: 'fixed',
                    dragShow: true
                },
                image: {
                    label: '{{__('Image')}}',
                    type: 'image',
                    format: function (value) {
                        return $filter('parseImage')(value);
                    }
                },
                slug: {
                    label: '{{__('Url')}}'
                },
                name: {
                    label: '{{__('Name')}}',
                    dragShow: true
                },
                order: {
                    label: '{{__('Order')}}',
                    order: API_URL + '/slide/sort'
                },
                status: {
                    label: '{{__('Status')}}',
                    type: 'status'
                }
            },
            actions: [
                {
                    label: '{{__('Edit')}}',
                    icon: 'fa fa-pencil fa-fw',
                    callback: function (row) {
                        $scope.edit(row);
                    }
                },
                {
                    label: '{{__('Delete')}}',
                    icon: 'fa fa-trash-o fa-fw',
                    callback: function (row) {
                        $scope.delete(row);
                    }
                }
            ],
            getData: function (params) {
                return Slide.query(params.url(), function (data) {
                    return data;
                });
            }
        });

        $scope.toggleStatus = function (row) {
            var $slide = angular.copy(row);
            $slide.status = !row.status;
            $slide.toggleStatus = true;
            $slide.$update(function (res) {
                row.status = !row.status;
                Notification.success('{{__('Saved successfully')}}');
            }, function (xhr) {
                if (xhr.status == 422) {
                    var validatorError = [];
                    for (key in xhr.data) {
                        validatorError.push(key + ': ' + (typeof xhr.data[key] =='string'?xhr.data[key]:xhr.data[key][0]));
                    }
                    Notification.error(validatorError.join('<br>'));
                }
            });
        };

        $scope.new = function () {
            $uibModal.open({
                animation: true,
                templateUrl: 'slide/new.html',
                controller: function ($scope, $uibModalInstance) {
                    $scope.slide = {
                        name: '',
                        slug: '',
                        image: null,
                        description: '',
                        status: true
                    };
                    $scope.save = function () {
                        var $slide = new Slide($scope.slide);
                        $slide.$save(function (res) {
                            reload();
                            $uibModalInstance.dismiss('close');
                            Notification.success('{{__('Saved successfully')}}');
                        }, function (xhr) {
                            if (xhr.status == 422) {
                                var validatorError = [];
                                for (key in xhr.data) {
                                    validatorError.push(key + ': ' + (typeof xhr.data[key] =='string'?xhr.data[key]:xhr.data[key][0]));
                                }
                                Notification.error(validatorError.join('<br>'));
                            }
                        });
                    };
                    $scope.close = function () {
                        $uibModalInstance.dismiss('close');
                    };
                },
                backdrop: 'static',
                windowClass: 'modal-full'
            });
        };

        $scope.edit = function (row) {
            Slide.get({id: row.id}, function (data) {
                $uibModal.open({
                    animation: true,
                    templateUrl: 'slide/edit.html',
                    controller: function ($scope, $uibModalInstance) {
                        $scope.slide = data;
                        $scope.name = angular.copy(data.name);
                        $scope.save = function () {
                            var $slide = angular.copy($scope.slide);
                            $slide.$update(function (res) {
                                row.name = angular.copy($scope.slide.name);
                                row.status = angular.copy($scope.slide.status);
                                row.image = angular.copy($scope.slide.image);
                                row.slug = angular.copy($scope.slide.slug);
                                $uibModalInstance.dismiss('close');
                                Notification.success('{{__('Saved successfully')}}');
                            }, function (xhr) {
                                if (xhr.status == 422) {
                                    var validatorError = [];
                                    for (key in xhr.data) {
                                        validatorError.push(key + ': ' + (typeof xhr.data[key] =='string'?xhr.data[key]:xhr.data[key][0]));
                                    }
                                    Notification.error(validatorError.join('<br>'));
                                }
                            });
                        };
                        $scope.close = function () {
                            $uibModalInstance.dismiss('close');
                        };
                    },
                    backdrop: 'static',
                    windowClass: 'modal-full'
                });
            });

        };

        $scope.delete = function (row) {
            Dialog.confirm(__('Are you sure you want to delete <b>:name</b>?', {name: row.name}))
                    .result.then(function () {
                row.$delete(function (res) {
                    reload();
                    Notification.success('{{__('Delete successfully')}}');
                })
            });
        };
    });
</script>
@endpush
@navbarcpanel([
    'icon' => 'fa fa-forward fa-fw',
    'label' => 'Slide',
    'permission' => 'slide',
    'name' => 'root.slide',
    'url' => 'slide',
    'template' => 'slide.html'
])
