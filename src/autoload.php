<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
spl_autoload_register(
    function($class) {
        static $classes = null;
        if ($classes === null) {
            $classes = array(
                'templado\\engine\\clearnamespacedefinitionsfilter' => '/../vendor/templado/engine/src/filters/ClearNamespaceDefinitionsFilter.php',
                'templado\\engine\\clearnamespacedefinitionsfilterexception' => '/../vendor/templado/engine/src/filters/ClearNamespaceDefinitionsFilterException.php',
                'templado\\engine\\csrfprotection' => '/../vendor/templado/engine/src/csrfprotection/CSRFProtection.php',
                'templado\\engine\\csrfprotectionrenderer' => '/../vendor/templado/engine/src/csrfprotection/CSRFProtectionRenderer.php',
                'templado\\engine\\cssselector' => '/../vendor/templado/engine/src/selectors/CSSSelector.php',
                'templado\\engine\\emptyelementsfilter' => '/../vendor/templado/engine/src/filters/EmptyElementsFilter.php',
                'templado\\engine\\emptyelementsfilterexception' => '/../vendor/templado/engine/src/filters/EmptyElementsFilterException.php',
                'templado\\engine\\exception' => '/../vendor/templado/engine/src/Exception.php',
                'templado\\engine\\filename' => '/../vendor/templado/engine/src/FileName.php',
                'templado\\engine\\filter' => '/../vendor/templado/engine/src/filters/Filter.php',
                'templado\\engine\\formdata' => '/../vendor/templado/engine/src/formdata/FormData.php',
                'templado\\engine\\formdataexception' => '/../vendor/templado/engine/src/formdata/FormDataException.php',
                'templado\\engine\\formdatarenderer' => '/../vendor/templado/engine/src/formdata/FormDataRenderer.php',
                'templado\\engine\\formdatarendererexception' => '/../vendor/templado/engine/src/formdata/FormDataRendererException.php',
                'templado\\engine\\html' => '/../vendor/templado/engine/src/Html.php',
                'templado\\engine\\selection' => '/../vendor/templado/engine/src/transformation/Selection.php',
                'templado\\engine\\selector' => '/../vendor/templado/engine/src/selectors/Selector.php',
                'templado\\engine\\simplesnippet' => '/../vendor/templado/engine/src/snippet/SimpleSnippet.php',
                'templado\\engine\\snapshotattributelist' => '/../vendor/templado/engine/src/viewmodel/SnapshotAttributeList.php',
                'templado\\engine\\snapshotattributelistexception' => '/../vendor/templado/engine/src/viewmodel/SnapshotAttributeListException.php',
                'templado\\engine\\snapshotdomnodelist' => '/../vendor/templado/engine/src/viewmodel/SnapshotDOMNodelist.php',
                'templado\\engine\\snapshotdomnodelistexception' => '/../vendor/templado/engine/src/viewmodel/SnapshotDOMNodelistException.php',
                'templado\\engine\\snippet' => '/../vendor/templado/engine/src/snippet/Snippet.php',
                'templado\\engine\\snippetcollectionexception' => '/../vendor/templado/engine/src/snippet/SnippetCollectionException.php',
                'templado\\engine\\snippetexception' => '/../vendor/templado/engine/src/snippet/SnippetException.php',
                'templado\\engine\\snippetlist' => '/../vendor/templado/engine/src/snippet/SnippetList.php',
                'templado\\engine\\snippetlistcollection' => '/../vendor/templado/engine/src/snippet/SnippetListCollection.php',
                'templado\\engine\\snippetloader' => '/../vendor/templado/engine/src/snippet/SnippetLoader.php',
                'templado\\engine\\snippetloaderexception' => '/../vendor/templado/engine/src/snippet/SnippetLoaderException.php',
                'templado\\engine\\snippetrenderer' => '/../vendor/templado/engine/src/snippet/SnippetRenderer.php',
                'templado\\engine\\snippetrendererexception' => '/../vendor/templado/engine/src/snippet/SnippetRendererException.php',
                'templado\\engine\\striprdfaattributestransformation' => '/../vendor/templado/engine/src/transformation/StripRDFaAttributesTransformation.php',
                'templado\\engine\\templado' => '/../vendor/templado/engine/src/Templado.php',
                'templado\\engine\\templadoexception' => '/../vendor/templado/engine/src/TempladoException.php',
                'templado\\engine\\templadosnippet' => '/../vendor/templado/engine/src/snippet/TempladoSnippet.php',
                'templado\\engine\\textsnippet' => '/../vendor/templado/engine/src/snippet/TextSnippet.php',
                'templado\\engine\\transformation' => '/../vendor/templado/engine/src/transformation/Transformation.php',
                'templado\\engine\\transformationprocessor' => '/../vendor/templado/engine/src/transformation/TransformationProcessor.php',
                'templado\\engine\\viewmodelrenderer' => '/../vendor/templado/engine/src/viewmodel/ViewModelRenderer.php',
                'templado\\engine\\viewmodelrendererexception' => '/../vendor/templado/engine/src/viewmodel/ViewModelRendererException.php',
                'templado\\engine\\xpathselector' => '/../vendor/templado/engine/src/selectors/XPathSelector.php',
                'templado\\engine\\xpathselectorexception' => '/../vendor/templado/engine/src/selectors/XPathSelectorException.php',
                'theseer\\application\\applicationstate' => '/app/state/ApplicationState.php',
                'theseer\\application\\applicationstateexception' => '/app/state/ApplicationStateException.php',
                'theseer\\application\\applicationstateservice' => '/app/state/ApplicationStateService.php',
                'theseer\\application\\applicationstatestore' => '/app/state/ApplicationStateStore.php',
                'theseer\\application\\badrequestexception' => '/app/commands/login/BadRequestException.php',
                'theseer\\application\\commandfactory' => '/app/commands/CommandFactory.php',
                'theseer\\application\\configuration' => '/app/Configuration.php',
                'theseer\\application\\exception' => '/app/Exception.php',
                'theseer\\application\\factory' => '/app/Factory.php',
                'theseer\\application\\insidequery' => '/app/queries/inside/InsideQuery.php',
                'theseer\\application\\insideroute' => '/app/queries/inside/InsideRoute.php',
                'theseer\\application\\logincommand' => '/app/commands/login/LoginCommand.php',
                'theseer\\application\\loginfailedresult' => '/app/commands/login/LoginFailedResult.php',
                'theseer\\application\\loginfailedresultroute' => '/app/commands/login/LoginFailedResultRoute.php',
                'theseer\\application\\loginrequired' => '/app/protected/LoginRequired.php',
                'theseer\\application\\loginrequiredresult' => '/app/protected/LoginRequiredResult.php',
                'theseer\\application\\loginrequiredresultroute' => '/app/protected/LoginRequiredResultRoute.php',
                'theseer\\application\\loginroute' => '/app/commands/login/LoginRoute.php',
                'theseer\\application\\loginsuccessresult' => '/app/commands/login/LoginSuccessResult.php',
                'theseer\\application\\loginsuccessresultroute' => '/app/commands/login/LoginSuccessResultRoute.php',
                'theseer\\application\\pdouserreader' => '/app/user/PdoUserReader.php',
                'theseer\\application\\protectedgetroute' => '/app/protected/ProtectedGetRoute.php',
                'theseer\\application\\protectedpostroute' => '/app/protected/ProtectedPostRoute.php',
                'theseer\\application\\queryfactory' => '/app/queries/QueryFactory.php',
                'theseer\\application\\stateawareresponse' => '/app/state/StateAwareResponse.php',
                'theseer\\application\\staticcontentprovider' => '/app/queries/static/StaticContentProvider.php',
                'theseer\\application\\staticmap' => '/app/queries/static/StaticMap.php',
                'theseer\\application\\staticmapexception' => '/app/queries/static/StaticMapException.php',
                'theseer\\application\\staticpageroute' => '/app/queries/static/StaticPageRoute.php',
                'theseer\\application\\stubuserreader' => '/app/user/StubUserReader.php',
                'theseer\\application\\user' => '/app/user/User.php',
                'theseer\\application\\userreader' => '/app/user/UserReader.php',
                'theseer\\application\\website' => '/app/Website.php',
                'theseer\\css2xpath\\dollarequalrule' => '/../vendor/theseer/css2xpath/src/DollarEqualRule.php',
                'theseer\\css2xpath\\notrule' => '/../vendor/theseer/css2xpath/src/NotRule.php',
                'theseer\\css2xpath\\nthchildrule' => '/../vendor/theseer/css2xpath/src/NthChildRule.php',
                'theseer\\css2xpath\\regexrule' => '/../vendor/theseer/css2xpath/src/RegexRule.php',
                'theseer\\css2xpath\\ruleinterface' => '/../vendor/theseer/css2xpath/src/RuleInterface.php',
                'theseer\\css2xpath\\translator' => '/../vendor/theseer/css2xpath/src/Translator.php',
                'theseer\\framework\\application' => '/framework/Application.php',
                'theseer\\framework\\csrftoken' => '/framework/token/CSRFToken.php',
                'theseer\\framework\\environment' => '/framework/Environment.php',
                'theseer\\framework\\exception' => '/framework/Exception.php',
                'theseer\\framework\\http\\abstractroute' => '/framework/http/request/AbstractRoute.php',
                'theseer\\framework\\http\\badrequestresponse' => '/framework/http/response/BadRequestResponse.php',
                'theseer\\framework\\http\\badrequestresult' => '/framework/http/result/BadRequestResult.php',
                'theseer\\framework\\http\\badrequestresultrenderer' => '/framework/http/result/renderer/BadRequestResultRenderer.php',
                'theseer\\framework\\http\\badrequestresultroute' => '/framework/http/result/routes/BadRequestResultRoute.php',
                'theseer\\framework\\http\\command' => '/framework/http/executables/Command.php',
                'theseer\\framework\\http\\content' => '/framework/http/Content.php',
                'theseer\\framework\\http\\contentprovider' => '/framework/http/ContentProvider.php',
                'theseer\\framework\\http\\contentresponse' => '/framework/http/response/ContentResponse.php',
                'theseer\\framework\\http\\cookies' => '/framework/http/request/maps/Cookies.php',
                'theseer\\framework\\http\\etag' => '/framework/http/ETag.php',
                'theseer\\framework\\http\\exception' => '/framework/http/Exception.php',
                'theseer\\framework\\http\\executable' => '/framework/http/executables/Executable.php',
                'theseer\\framework\\http\\files' => '/framework/http/request/maps/Files.php',
                'theseer\\framework\\http\\filesexception' => '/framework/http/request/post/FilesException.php',
                'theseer\\framework\\http\\formpostrequest' => '/framework/http/request/post/FormPostRequest.php',
                'theseer\\framework\\http\\genericrequest' => '/framework/http/request/GenericRequest.php',
                'theseer\\framework\\http\\getrequest' => '/framework/http/request/get/GetRequest.php',
                'theseer\\framework\\http\\getroute' => '/framework/http/request/GetRoute.php',
                'theseer\\framework\\http\\headers' => '/framework/http/request/maps/Headers.php',
                'theseer\\framework\\http\\headrequest' => '/framework/http/request/get/HeadRequest.php',
                'theseer\\framework\\http\\internalerrorresponse' => '/framework/http/response/InternalErrorResponse.php',
                'theseer\\framework\\http\\internalerrorresultrenderer' => '/framework/http/result/renderer/InternalErrorResultRenderer.php',
                'theseer\\framework\\http\\internalservererrorresult' => '/framework/http/result/InternalServerErrorResult.php',
                'theseer\\framework\\http\\internalservererrorresultroute' => '/framework/http/result/routes/InternalServerErrorResultRoute.php',
                'theseer\\framework\\http\\invalidrequestexception' => '/framework/http/request/InvalidRequestException.php',
                'theseer\\framework\\http\\jsonpostrequest' => '/framework/http/request/post/JsonPostRequest.php',
                'theseer\\framework\\http\\methodnotallowedexecutable' => '/framework/http/executables/MethodNotAllowedExecutable.php',
                'theseer\\framework\\http\\methodnotallowedresponse' => '/framework/http/response/MethodNotAllowedResponse.php',
                'theseer\\framework\\http\\methodnotallowedresult' => '/framework/http/result/MethodNotAllowedResult.php',
                'theseer\\framework\\http\\methodnotallowedresultrenderer' => '/framework/http/result/renderer/MethodNotAllowedResultRenderer.php',
                'theseer\\framework\\http\\methodnotallowedresultroute' => '/framework/http/result/routes/MethodNotAllowedResultRoute.php',
                'theseer\\framework\\http\\notfoundexecutable' => '/framework/http/executables/NotFoundExecutable.php',
                'theseer\\framework\\http\\notfoundresponse' => '/framework/http/response/NotFoundResponse.php',
                'theseer\\framework\\http\\notfoundresult' => '/framework/http/result/NotFoundResult.php',
                'theseer\\framework\\http\\notfoundresultrenderer' => '/framework/http/result/renderer/NotFoundResultRenderer.php',
                'theseer\\framework\\http\\notfoundresultroute' => '/framework/http/result/routes/NotFoundResultRoute.php',
                'theseer\\framework\\http\\notfoundroute' => '/framework/http/request/NotFoundRoute.php',
                'theseer\\framework\\http\\notimplementedexecutable' => '/framework/http/executables/NotImplementedExecutable.php',
                'theseer\\framework\\http\\notimplementedresponse' => '/framework/http/response/NotImplementedResponse.php',
                'theseer\\framework\\http\\notimplementedresult' => '/framework/http/result/NotImplementedResult.php',
                'theseer\\framework\\http\\notimplementedresultrenderer' => '/framework/http/result/renderer/NotImplementedResultRenderer.php',
                'theseer\\framework\\http\\notimplementedresultroute' => '/framework/http/result/routes/NotImplementedResultRoute.php',
                'theseer\\framework\\http\\notmodifiedresponse' => '/framework/http/response/NotModifiedResponse.php',
                'theseer\\framework\\http\\notmodifiedresult' => '/framework/http/result/NotModifiedResult.php',
                'theseer\\framework\\http\\notmodifiedresultrenderer' => '/framework/http/result/renderer/NotModifiedResultRenderer.php',
                'theseer\\framework\\http\\notmodifiedresultroute' => '/framework/http/result/routes/NotModifiedResultRoute.php',
                'theseer\\framework\\http\\outofroutesexception' => '/framework/http/request/OutOfRoutesException.php',
                'theseer\\framework\\http\\parameters' => '/framework/http/request/maps/Parameters.php',
                'theseer\\framework\\http\\postrequest' => '/framework/http/request/post/PostRequest.php',
                'theseer\\framework\\http\\postroute' => '/framework/http/request/PostRoute.php',
                'theseer\\framework\\http\\query' => '/framework/http/executables/Query.php',
                'theseer\\framework\\http\\rawpostrequest' => '/framework/http/request/post/RawPostRequest.php',
                'theseer\\framework\\http\\redirectresponse' => '/framework/http/response/RedirectResponse.php',
                'theseer\\framework\\http\\redirectresultrenderer' => '/framework/http/result/renderer/RedirectResultRenderer.php',
                'theseer\\framework\\http\\request' => '/framework/http/request/Request.php',
                'theseer\\framework\\http\\requestexception' => '/framework/http/request/RequestException.php',
                'theseer\\framework\\http\\requestrouter' => '/framework/http/request/RequestRouter.php',
                'theseer\\framework\\http\\response' => '/framework/http/response/Response.php',
                'theseer\\framework\\http\\result' => '/framework/http/result/Result.php',
                'theseer\\framework\\http\\resultrenderer' => '/framework/http/result/renderer/ResultRenderer.php',
                'theseer\\framework\\http\\resultroute' => '/framework/http/result/routes/ResultRoute.php',
                'theseer\\framework\\http\\resultrouter' => '/framework/http/result/routes/ResultRouter.php',
                'theseer\\framework\\http\\resultroutetemplate' => '/framework/http/result/routes/ResultRouteTemplate.php',
                'theseer\\framework\\http\\route' => '/framework/http/request/Route.php',
                'theseer\\framework\\http\\uploadedfile' => '/framework/http/request/post/UploadedFile.php',
                'theseer\\framework\\http\\uploadedfileexception' => '/framework/http/request/post/UploadedFileException.php',
                'theseer\\framework\\http\\uploadpostrequest' => '/framework/http/request/post/UploadPostRequest.php',
                'theseer\\framework\\json' => '/framework/common/Json.php',
                'theseer\\framework\\jsonexception' => '/framework/common/JsonException.php',
                'theseer\\framework\\keyvaluemap' => '/framework/common/KeyValueMap.php',
                'theseer\\framework\\keyvaluemapexception' => '/framework/common/KeyValueMapException.php',
                'theseer\\framework\\page\\page' => '/framework/page/Page.php',
                'theseer\\framework\\page\\pageexception' => '/framework/page/PageException.php',
                'theseer\\framework\\page\\pagefileloader' => '/framework/page/PageFileLoader.php',
                'theseer\\framework\\page\\pagequery' => '/framework/page/PageQuery.php',
                'theseer\\framework\\page\\pageresult' => '/framework/page/PageResult.php',
                'theseer\\framework\\page\\pageresultrenderer' => '/framework/page/PageResultRenderer.php',
                'theseer\\framework\\page\\pageresultroute' => '/framework/page/PageResultRoute.php',
                'theseer\\framework\\runner' => '/framework/Runner.php',
                'theseer\\framework\\sessionid' => '/framework/token/SessionId.php',
                'theseer\\framework\\tokengenerator' => '/framework/token/TokenGenerator.php',
                'theseer\\framework\\url' => '/framework/common/Url.php'
            );
        }
        $cn = strtolower($class);
        if (isset($classes[$cn])) {
            require __DIR__ . $classes[$cn];
        }
    },
    true,
    false
);
// @codeCoverageIgnoreEnd
