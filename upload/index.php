<!DOCTYPE html>
<html id="ng-app" ng-app="app"> <!-- id="ng-app" IE<8 -->

    <head>
        <title>Subir archivos al servidor</title>
        <link rel="stylesheet" href="bootstrap.min.css" />

        <!-- Fix for old browsers -->
        <script src="es5-shim.min.js"></script>
        <script src="jquery-1.8.3.min.js"></script>
        <script src="console-sham.min.js"></script>

        <!--         <script src="bootstrap.min.js"></script> -->

        <!--<script src="../bower_components/angular/angular.js"></script>-->
        <script src="angular.min.js"></script>
        <script src="simple.min.js"></script>
        <script src="controllers.js"></script>

        <style>
            .my-drop-zone { border: dotted 3px lightgray; }
            .nv-file-over { border: dotted 3px red; } /* Default class applied to drop zones on over */
            .another-file-over-class { border: dotted 3px green; }

            html, body {
                height: 100%; 
                font-size: 13px;
            }
        </style>

    </head>

    <!-- 1. nv-file-drop="" uploader="{Object}" options="{Object}" filters="{String}" -->
    <body ng-controller="AppController" nv-file-drop="" uploader="uploader" filters="queueLimit, customFilter">

        <div class="container">

 

            <div class="row">

                <div class="col-md-3">

                    <div ng-show="uploader.isHTML5">
                        <!-- 3. nv-file-over uploader="link" over-class="className" -->
                        <div class="well my-drop-zone" nv-file-over="" uploader="uploader">
                            Arrastre aqui el archivo a adjuntar
                        </div>
                    </div>

                </div>

                <div class="col-md-9" style="margin-bottom: 40px">

                    <table class="table">
                        <thead>
                            <tr>
                                <th width="50%">Nombre</th>
                                <th ng-show="uploader.isHTML5">Tamaño</th>
                                <th ng-show="uploader.isHTML5">Progreso</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="item in uploader.queue">
                                <td><strong>{{ item.file.name }}</strong></td>
                                <td ng-show="uploader.isHTML5" nowrap>{{ item.file.size/1024/1024|number:2 }} MB</td>
                                <td ng-show="uploader.isHTML5">
                                    <div class="progress" style="margin-bottom: 0;">
                                        <div class="progress-bar" role="progressbar" ng-style="{ 'width': item.progress + '%' }"></div>
                                    </div>
                                </td>
                                <td nowrap>
                                    <button type="button" class="btn btn-success btn-xs" ng-click="item.upload()" ng-disabled="item.isReady || item.isUploading || item.isSuccess">
                                        <span class="glyphicon glyphicon-upload"></span> Subir
                                    </button>
                                    <button type="button" class="btn btn-danger btn-xs" ng-click="item.remove()">
                                        <span class="glyphicon glyphicon-trash"></span> Eliminar
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>

            </div>

        </div>

    </body>
</html>
