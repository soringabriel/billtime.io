import Prism from 'prismjs';
import 'prismjs/plugins/toolbar/prism-toolbar.js';
import 'prismjs/plugins/copy-to-clipboard/prism-copy-to-clipboard.js';

require('prismjs/components/prism-markup-templating');
require('prismjs/components/prism-json');
require('prismjs/components/prism-bash');
require('prismjs/components/prism-javascript');
require('prismjs/components/prism-ruby');
require('prismjs/components/prism-php');
require('prismjs/components/prism-go');
require('prismjs/components/prism-csharp');
require('prismjs/components/prism-python');
require('prismjs/components/prism-java');

var HTTPSnippet = require('httpsnippet');

$(".test-api-playground .execute").on('click', function() {
    var el = $(this).parents(".test-api-playground").first();
    if (!el.find('.url').first().val().includes(window.location.hostname)) {
        el.find('.result code pre').first().html("The given URL is not from this website");
        el.find('.result .code-block .status').first().html("");
        el.find('.loader').first().hide();
        return;
    }
    $.ajax({
        type: el.find('.method').first().val(),
        url: el.find('.url').first().val(),
        headers: processHeaders(el),
        data: processParams(el),
        beforeSend: function() {
            el.find('.result').first().show();
            el.find('.loader').first().show();
        },
        complete: function(data) {
            try {
                var stringifiedJSON = JSON.stringify(data.responseJSON, null, 4);
                el.find('.result code pre').first().html(JSON.stringify(data.responseJSON, null, 4).trim());
                el.find('.result .code-block .status').first().html(JSON.stringify(data.status).trim());
                el.find('.loader').first().hide();
            } catch (error) {
                el.find('.result code pre').first().html("An unexpected error has occured. Please make sure you're using the correct URL.");
                el.find('.result .code-block .status').first().html("500");
                el.find('.loader').first().hide();
            }
        }
    });
})

$(".test-api-playground input").on("change", function() {
    var el = $(this).parents(".test-api-playground").first();
    generateAllCodes(el);
})

$(".test-api-playground").each(function(){
    generateAllCodes($(this));
})

function generateAllCodes(el) {
    var languages = ['curl', 'nodejs', 'python', 'php', 'go', 'java', 'csharp', 'ruby'];
    for (var index in languages) {
        testApiPlaygroundGenerateCode(el, languages[index]);
    }
}

function testApiPlaygroundGenerateCode(el, lang) {
    var snippet = new HTTPSnippet({
        method: el.find('.method').first().val(),
        headers: processHeadersHar(el),
        queryString: processParamsHar(el),
        url: el.find('.url').first().val()
    });
    var typeLanguage = testApiPlaygroundTypeCode(lang, {indent: '\t'});
    var codeSnippet = snippet.convert(typeLanguage.lang);
    el.find(".language-" + lang).first().html(Prism.highlight(codeSnippet, typeLanguage.prism));
    $(".code-toolbar button").each(function(){
        $(this).addClass("btn btn-primary");
    })
}

function testApiPlaygroundTypeCode(language) {
    var lang = "";
    var variant = "";
    var prism = null;

    switch(language) {
        case "nodejs":
            lang = "node"
            variant = "axios"
            prism = Prism.languages.javascript
            break;
        case "python":
            lang = "python"
            variant = "http.client"
            prism = Prism.languages.python
            break;
        case "php":
            lang = "php"
            variant = "cURL"
            prism = Prism.languages.php
            break;
        case "golang":
            lang = "go"
            variant = "native"
            prism = Prism.languages.go
            break;
        case "java":
            lang = "java"
            variant = "OkHttp"
            prism = Prism.languages.java
            break;
        case "dotnet":
            lang = "csharp"
            variant = "RestSharp"
            prism = Prism.languages.csharp
            break;
        case "ruby":
            lang = "ruby"
            variant = "Net::HTTP"
            prism = Prism.languages.ruby
            break;
        default:
            lang = "shell"
            variant = "curl"
            prism = Prism.languages.bash
    }

    return {lang, variant, prism}
}

function processHeaders(el) {
    var headers = {};
    el.find(".headers .parameter").each(function(){
        if ($(this).find('input').first().is(":checked")) {
            headers[$(this).find('input').eq(1).val()] = $(this).find('input').eq(2).val();
        }
    })
    return headers;
}

function processParams(el) {
    var params = {};
    el.find(".params .parameter").each(function(){
        if ($(this).find('input').first().is(":checked")) {
            params[$(this).find('input').eq(1).val()] = $(this).find('input').eq(2).val();
        }
    })
    return params;
}

function processHeadersHar(el) {
    var headers = [];
    el.find(".headers .parameter").each(function(){
        if ($(this).find('input').first().is(":checked")) {
            headers.push({
                "name": $(this).find('input').eq(1).val(),
                "value": $(this).find('input').eq(2).val(),
                "comment": ""
            });
        }
    })
    return headers;
}

function processParamsHar(el) {
    var params = [];
    el.find(".params .parameter").each(function(){
        if ($(this).find('input').first().is(":checked")) {
            params.push({
                "name": $(this).find('input').eq(1).val(),
                "value": $(this).find('input').eq(2).val(),
                "comment": ""
            });
        }
    })
    return params;
}