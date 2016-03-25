define({ "api": [
  {
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "varname1",
            "description": "<p>No type.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "varname2",
            "description": "<p>With type.</p>"
          }
        ]
      }
    },
    "type": "",
    "url": "",
    "version": "0.0.0",
    "filename": "./web/docs/main.js",
    "group": "C__Users_mille_projetos_silex_api_web_docs_main_js",
    "groupTitle": "C__Users_mille_projetos_silex_api_web_docs_main_js",
    "name": ""
  },
  {
    "type": "DELETE",
    "url": "/fabricante/:id",
    "title": "Remove Fabricante por id",
    "name": "DeleteFabricante",
    "group": "Fabricante",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>ID Unico do Fabricante</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Bolean",
            "optional": false,
            "field": "status",
            "description": "<p>200</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "message",
            "description": "<p>Mensagem de Sucesso</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Boelan",
            "optional": false,
            "field": "status",
            "description": "<p>0</p>"
          },
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Mensagem de Erro</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "./web/index.php",
    "groupTitle": "Fabricante"
  },
  {
    "type": "GET",
    "url": "/fabricante",
    "title": "Busca todos os Fabricantes",
    "name": "GetFabricante",
    "group": "Fabricante",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Bolean",
            "optional": false,
            "field": "status",
            "description": "<p>200</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "response",
            "description": "<p>Todos os Fabricantes.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "./web/index.php",
    "groupTitle": "Fabricante"
  },
  {
    "type": "POST",
    "url": "/fabricante",
    "title": "Adiciona novo Fabricante",
    "name": "PostFabricante",
    "group": "Fabricante",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "bome",
            "description": "<p>Nome do Fabricante</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Bolean",
            "optional": false,
            "field": "status",
            "description": "<p>200</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "response",
            "description": "<p>Dados do Fabricante criado</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Boelan",
            "optional": false,
            "field": "status",
            "description": "<p>0</p>"
          },
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Mensagem de Erro</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "./web/index.php",
    "groupTitle": "Fabricante"
  },
  {
    "type": "GET",
    "url": "/fabricante/:id",
    "title": "Busca Fabricante por id",
    "name": "PostFabricante",
    "group": "Fabricante",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>ID Unico do Fabricante</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Bolean",
            "optional": false,
            "field": "status",
            "description": "<p>200</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "response",
            "description": "<p>Dados do Fabricante</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Boelan",
            "optional": false,
            "field": "status",
            "description": "<p>0</p>"
          },
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Mensagem de Erro</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "./web/index.php",
    "groupTitle": "Fabricante"
  },
  {
    "type": "PUT",
    "url": "/fabricante/:id",
    "title": "Atualiza Fabricante por id",
    "name": "PutFabricante",
    "group": "Fabricante",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<p>ID Unico do Fabricante</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "nome",
            "description": "<p>Nome do Fabricante</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Bolean",
            "optional": false,
            "field": "status",
            "description": "<p>200</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "response",
            "description": "<p>Dados do Fabricante</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Boelan",
            "optional": false,
            "field": "status",
            "description": "<p>0</p>"
          },
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Mensagem de Erro</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "./web/index.php",
    "groupTitle": "Fabricante"
  },
  {
    "type": "GET",
    "url": "/produto",
    "title": "Busca todos os Produtos",
    "name": "GetProduto",
    "group": "Produto",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Bolean",
            "optional": false,
            "field": "status",
            "description": "<p>200</p>"
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "response",
            "description": "<p>Todos os Produtos.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n {\n     \"id\": 5,\n     \"nome\": \"Produto 1\",\n     \"garantia\": \"6 meses\",\n     \"grade\": \"0\",\n     \"fabricante\": {\n         \"id\": 3,\n         \"nome\": \"Fabricante 1\"\n     },\n     \"estoque\": [\n     {\n         \"id\": 1,\n         \"quantidade\": 51,\n         \"filial\": {\n             \"id\": 1,\n             \"nome\": \"Filial 1\"\n         }\n     },\n     {\n         \"id\": 5,\n         \"quantidade\": 10,\n         \"filial\": {\n             \"id\": 2,\n             \"nome\": \"Filial 2\"\n         }\n      }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./web/index.php",
    "groupTitle": "Produto"
  }
] });
