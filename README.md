# payment-approvals

## 1. Registration

```http
POST /api/register
```

| Parameter | Type | Description |
| :--- | :--- | :--- |
| `first_name` | `string` | **Required**. |
| `last_name` | `string` | **Required**. |
| `password` | `string` | **Required**. |
| `confirm_password` | `string` | **Required**. Same as initial password |
| `email` | `string` | **Required**. |

** Response example **

```javascript
{
    "success": true,
    "data": {
        "token": "6|A0hv5bgsUt8LBgCxHp5D3uaG0mPwgNvIS2vpXQy5",
        "name": "Anja"
    },
    "message": "User registered successfully."
}
```

## 2. Login

```http
POST /api/login
```

| Parameter | Type | Description |
| :--- | :--- | :--- |
| `email` | `string` | **Required**. |
| `password` | `string` | **Required**. |

** Response example **

```javascript
{
    "success": true,
    "data": {
        "token": "8|imMs9bUoH7nVMz1WATIjp36lpSPQngbr21WZsufr",
        "name": "Anja"
    },
    "message": "User login successfully."
}
```


## 3. Store Payments
**Bearer Token is required**

**Allowed for all users**
```http
POST /api/payments
```

| Parameter | Type | Description |
| :--- | :--- | :--- |
| `total_amount` | `float` | **Required**. |

** Response example **

```javascript
{
    "success": true,
    "data": {
        "id": 2,
        "user": "Anja Anzel",
        "amount": "56550",
        "created_at": "29/12/2022",
        "updated_at": "29/12/2022"
    },
    "message": "Payment created successfully."
}
```

## 4. Store Travel Payments ##
**Bearer Token is required**

**Allowed for all users**
```http
POST /api/travel-payments
```

| Parameter | Type | Description |
| :--- | :--- | :--- |
| `amount` | `float` | **Required**. |

** Response example **

```javascript
{
    "success": true,
    "data": {
        "id": 2,
        "user": "Anja Anzel",
        "amount": "56550",
        "created_at": "29/12/2022",
        "updated_at": "29/12/2022"
    },
    "message": "Payment created successfully."
}
```

## 5. Retreive Payments ##
**Bearer Token is required**

**Allowed only for APPROVERS**
```http
GET /api/payments
```

** Response example **

```javascript
{
    "success": true,
    "data": [
        {
            "id": 2,
            "user": "Anja Anzel",
            "amount": 56550,
            "created_at": "29/12/2022",
            "updated_at": "29/12/2022"
        },
        {
            "id": 3,
            "user": "Anja Anzel",
            "amount": 56550,
            "created_at": "29/12/2022",
            "updated_at": "29/12/2022"
        }
    ],
    "message": "Payments retrieved successfully."
}
```


## 6. Retreive a specific Payment ##
**Bearer Token is required**

**Allowed only for APPROVERS**
```http
GET /api/payments/{id}
```

** Response example **

```javascript
{
    "success": true,
    "data": {
        "id": 3,
        "user": "Anja Anzel",
        "amount": 56550,
        "created_at": "29/12/2022",
        "updated_at": "29/12/2022"
    },
    "message": "Payment retrieved successfully."
}
```

## 7. Update a specific Payment ##
**Bearer Token is required**

**Allowed only for APPROVERS**
```http
PUT /api/payments/{id}
```
| Parameter | Type | Description |
| :--- | :--- | :--- |
| `total_amount` | `float` | **Required**. |

** Response example **

```javascript
{
    "success": true,
    "data": {
        "id": 3,
        "user": "Anja Anzel",
        "amount": "2222",
        "created_at": "29/12/2022",
        "updated_at": "29/12/2022"
    },
    "message": "Payment updated successfully."
}
```

## 8. Delete a specific Payment ##
**Bearer Token is required**

**Allowed only for APPROVERS**
```http
DELETE /api/payments/{id}
```

** Response example **

```javascript
{
    "success": true,
    "data": [],
    "message": "Payment deleted successfully."
}
```

## 9-12 equivalent travel payments CRUD ##

## 13. Approve a specific Payment ##
**Bearer Token is required**

**Allowed only for APPROVERS**
```http
POST /api/approve
```
| Parameter | Type | Description |
| :--- | :--- | :--- |
| `payment_id` | `int` | **Required**. |
| `payment_type` | `string` | **Required**. enum in: REGULAR or TRAVEL|
| `status` | `string` | **Required**. enum in: APPROVED or DISAPPROVED|

** Response example **

```javascript
{
    "success": true,
    "data": {
        "approver": "Jane Doe",
        "payment_type": "REGULAR",
        "payment": "Payment no.7 by Anja Anzel: 5655",
        "voted_at": "28/12/2022 23:12:46"
    },
    "message": "REGULAR payment no. 7 APPROVED"
}
```

## 14. Report ##
**Bearer Token is required**

**Allowed only for APPROVERS**
```http
GET /api/report
```
** Response example **

```javascript
{
    "success": true,
    "data": [
        {
            "approver": "Anja Anzel",
            "numberOfGivenApprovals": 0,
            "numberOfApprovedPayments": 0
        },
        {
            "approver": "Jane Doe",
            "numberOfGivenApprovals": 5,
            "numberOfApprovedPayments": 3
        },
        {
            "approver": "Michael Scott",
            "numberOfGivenApprovals": 3,
            "numberOfApprovedPayments": 2
        }
    ],
    "message": "Successfully retrieved data."
}
```
