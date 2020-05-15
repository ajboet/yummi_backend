# API Endpoints

## Headers

`auth user only` = a valid `auth:sanctum` Bearer token must be present in request's Authorization Header

The following headers must be present in every request to all endpoints:

| Header       | Value            |
| ------------ | ---------------- |
| Content-Type | application/json |
| Accept       | application/json |

## Methods

### POST
* User SignIn
```
/api/login/
```
| Parameter  | Details  |
| ---------- | -------- |
| email      | required |
| password   | required |

* User SignUp
```
/api/signup/
```
| Parameter             | Details  |
| --------------------- |:--------:|
| name                  | required |
| email                 |     "    |
| password              |     "    |
| password_confirmation |     "    |
| cellphone_number      |     "    |
| full_address          |     "    |

* Add a Product to the Shopping Cart
```
/api/order/add/{product}/
```
> {product} is a Product model binded ID (Route Model Binding)

* Order Item increment
```
/api/order/item/increment/
```
| Parameter     | Details  |
| ------------- | -------- |
| cartItemIndex | required |

* Order Item increment
```
/api/order/item/decrement/
```
| Parameter     | Details  |
| ------------- | -------- |
| cartItemIndex | required |

* Order Item increment
```
/api/order/item/remove/
```
| Parameter     | Details  |
| ------------- | -------- |
| cartItemIndex | required |

* Order confirmation
```
/api/confirm_order/
```
| Parameter             | Details                                     |
| --------------------- |:-------------------------------------------:|
| name                  | required if no Authorization Header present |
| email                 |                        "                    |
| password              |                        "                    |
| password_confirmation |                        "                    |
| cellphone_number      |                        "                    |
| full_address          |                        "                    |


### GET

* User Info `auth user only`
```
/api/user/
```

* User SignOut `auth user only`
```
/api/logout/
```

* User Order Record List `auth user only`
```
/api/order_record/
```

* Retrieve Order data
```
/api/order/
```

* Display a listing of the resource
```
/api/product/
```

* Display the specified resource
```
/api/product/{product}/
```
> {product} is a Product model binded ID (Route Model Binding)


### PATCH

* User Info Update `auth user only`
```
/api/update/
```
| Parameter             | Details  |
| --------------------- |:--------:|
| name                  | optional |
| email                 |     "    |
| password              |     "    |
| password_confirmation |     "    |
| cellphone_number      |     "    |
| full_address          |     "    |

### DELETE

* Delete Order
```
/api/order/delete/
```
