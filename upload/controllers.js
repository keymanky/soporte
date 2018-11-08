'use strict';


angular


    .module('app', ['angularFileUpload'])


    .controller('AppController', ['$scope', 'FileUploader', function($scope, FileUploader) {
        var uploader = $scope.uploader = new FileUploader({
            url: 'upload.php'
        });

        // FILTERS

        uploader.filters.push({
            name: 'customFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                return this.queue.length < 1;
            }
        });

        // CALLBACKS

        uploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
            // console.info('onWhenAddingFileFailed', item, filter, options);
        };
        uploader.onAfterAddingFile = function(fileItem) {
            if(fileItem.file.size < 2000000){
                $scope.uploader.uploadAll();
            }else{
                alert("El archivo no puede ser cargado, supera el tamaño maximo 2MB");
                window.localStorage.removeItem("archivo")
                window.location.reload();
            }
            console.log(fileItem.file.size);
            // console.info('onAfterAddingFile', fileItem);
        };
        uploader.onAfterAddingAll = function(addedFileItems) {
            // console.info('onAfterAddingAll', addedFileItems);
        };
        uploader.onBeforeUploadItem = function(item) {
            // console.info('onBeforeUploadItem', item);
        };
        uploader.onProgressItem = function(fileItem, progress) {
            // console.info('onProgressItem', fileItem, progress);
        };
        uploader.onProgressAll = function(progress) {
            // console.info('onProgressAll', progress);
        };
        uploader.onSuccessItem = function(fileItem, response, status, headers) {
            // console.info('onSuccessItem', fileItem, response, status, headers);
        };
        uploader.onErrorItem = function(fileItem, response, status, headers) {
            alert("No se pudo adjuntar el archivo");
        };
        uploader.onCancelItem = function(fileItem, response, status, headers) {
        };
        uploader.onCompleteItem = function(fileItem, response, status, headers) {
            //alert(fileItem.file.name)
            window.localStorage.setItem("archivo",fileItem.file.name);
            //console.log(fileItem.file.name)
            //window.localStorage.setItem("archivo",fileItem.file.name);
        };
        uploader.onCompleteAll = function(e) {
            //alert("Se adjunto correctamente el archivo")
            //window.close();
            //window.open("cerrar_window2.html","miventana","width=300,height=200,menubar=no")
        };
        console.info('uploader', uploader);
    }]);
