# bar.golf

## API Endpoints
### GET `api/index.php/login/{password}`
Returns 
```json
{
  "data": {
    "id": 5,
    "name": "Marcus"
  },
  "success": 1
}
```
Save this player `id` to the session, you'll need to send it in the PUT request to upsert a player action.
### GET `api/index.php/everything`
Returns 
```json
{
  "data": {
    "players": [
      {
        "id": 1,
        "name": "Kit",
        "bars": [
          {
            "id": 100,
            "name": "James Joyce",
            "action_id": 1,
            "action_description": "{{james joyce par}}",
            "numerical_score": 0,
            "score": "Par"
          },
          {
            "id": 200,
            "name": "First Chance Last Chance",
            "action_id": 4,
            "action_description": "{{fclc birdie}}",
            "numerical_score": -1,
            "score": "Birdie"
          }
        ],
        "bars_completed": 2,
        "total_score": "-1"
      },
      {
        "id": 2,
        "name": "Devon",
        "bars": [
          
        ],
        "bars_completed": null,
        "total_score": null
      },
      {
        "id": 3,
        "name": "Steve",
        "bars": [
          
        ],
        "bars_completed": null,
        "total_score": null
      },
      {
        "id": 4,
        "name": "Marissa",
        "bars": [
          
        ],
        "bars_completed": null,
        "total_score": null
      },
      {
        "id": 5,
        "name": "Marcus",
        "bars": [
          
        ],
        "bars_completed": null,
        "total_score": null
      },
      {
        "id": 6,
        "name": "Hannah",
        "bars": [
          
        ],
        "bars_completed": null,
        "total_score": null
      },
      {
        "id": 7,
        "name": "Andrea",
        "bars": [
          
        ],
        "bars_completed": null,
        "total_score": null
      }
    ],
    "bars": [
      {
        "id": 100,
        "name": "James Joyce",
        "url": "https:\/\/goo.gl\/maps\/LhPUiHu77UH2",
        "iframe": null,
        "actions": [
          {
            "id": 2,
            "description": "{{james joyce birdie}}",
            "numerical_score": -1,
            "score": "Birdie"
          },
          {
            "id": 1,
            "description": "{{james joyce par}}",
            "numerical_score": 0,
            "score": "Par"
          }
        ]
      },
      {
        "id": 200,
        "name": "First Chance Last Chance",
        "url": "https:\/\/goo.gl\/maps\/xz4twUPmgz42",
        "iframe": null,
        "actions": [
          {
            "id": 4,
            "description": "{{fclc birdie}}",
            "numerical_score": -1,
            "score": "Birdie"
          },
          {
            "id": 3,
            "description": "{{fclc par}}",
            "numerical_score": 0,
            "score": "Par"
          }
        ]
      },
      {
        "id": 300,
        "name": "Gaspar's Grotto",
        "url": "https:\/\/goo.gl\/maps\/bPKgKEFd5gD2",
        "iframe": null,
        "actions": [
          
        ]
      }
    ]
  },
  "success": 1
}
```

### PUT `/players/{player_id}/{bar_id}/{action_id}`
Returns
```json
{
  "data": "Success",
  "success": 1
}
```
