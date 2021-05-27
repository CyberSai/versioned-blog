<p align="center">
<img alt="GitHub Workflow Status (branch)" src="https://img.shields.io/github/workflow/status/CyberSai/versioned-blog/Laravel/main?label=main%20build">
<img alt="Codecov branch" src="https://img.shields.io/codecov/c/github/CyberSai/versioned-blog/main?label=main%20coverage">
<img alt="GitHub Workflow Status (branch)" src="https://img.shields.io/github/workflow/status/CyberSai/versioned-blog/Laravel/v2.x?label=v2.x%20build">
<img alt="Codecov branch" src="https://img.shields.io/codecov/c/github/CyberSai/versioned-blog/v2.x?label=v2.x%20coverage">
<img alt="GitHub Workflow Status (branch)" src="https://img.shields.io/github/workflow/status/CyberSai/versioned-blog/Laravel/v1.x?label=v1.x%20build">
<img alt="Codecov branch" src="https://img.shields.io/codecov/c/github/CyberSai/versioned-blog/v1.x?label=v1.x%20coverage">
</p>

## About Versioned Blog

This is an experiment blog to play around with versioning multiple api at the same time in the same code base using limited resource. The idea is to be able to seamlessly update api while supporting older versions this you decide to deprecate later.

## Approach used

To distinguish between version, the client has to pass the right version through the route.

```js
axios.get("https://backend.com/api/1/users")
// or
axios.get("https://backend.com/api/2/users")
```

Since semantic versioning is used minor and patches are not expected to introduction braking changes hence there is no need to specify the exact version.

## Outcome

After working on this project, the following are the observed outcomes. They are grouped in pros and cons.

### Cons

#### Versioning Logic is scatter very where in the code base

There is no right place to version your code, it can be done in the **route**, **controller**, **middleware**, **gate/policy**, **resource** or **model**. This makes it more difficult to know where the modification was done at.

#### Maintaining backward compatibility is solely the develops responsibility

It no magic that previous versions will not work as intended, the develop as to make sure they work as previous and new code does not break old ones. This can be very difficult to achieve at times.

#### Writing Test becomes hard to organise

The develop has to be smart to know how to organize test and avoid repeativity test cases for every version, else the work load becomes  anover a burden. Some of this can be avoided by using dataProviders instead of versioning the test as well.

### Pros

#### Easy maintenance for various versions

This approach considers only the major versions hence, minor and patches update the major version with the latest fixes without considering maintaining previous minor version. That means no matter the version specified by the client, it will receive the latest major.minor.patch version. It becomes much easy to maintain one version across a major version than several minors/patches within one version. Great for small team if the deprecate older versions often.

#### Avoid copying version codes that does not change

When moving from one major version to another, not all the code changes. And there is no need to copy logics from older versions to the new ones. This is because the versioning is dynamic implemented.

#### Clients do not have to support multiple versions at a time

When clients have to specify different version for different endpoints, it become cumbersome for them to know how to version their own code to compliment the server. Eg. have version 3 client connecting to server version 1, 2 and 3 is not idea for the client. But with this approch, the client just have to focus on one version at a time. This way mobile application deployed to the app store can confidently use one version at a time. It makes it easily to know when to ask clients to update.

### Considerations

The use of route parameter to version is great, but at the server end (i.e laravel to be specific), you need to pass the server version as the first parameter to controller methods. This means extra one parameter in the controller weather it will be used or not. You also have to manual get the value in other places. It will be more appealing to pass the version in the headers. So instead of

```php
<?php

// In Controller
class PostController extends Controller
{
    public function index(int $version, User $user)
    {
        $posts = $user->posts()->latest()->simplePaginate();

        return PostResource::collection($posts);
    }
}

// In Resource
class PostResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'user' => new UserResource($this->whenLoaded('user')),
            $this->mergeWhen($request->route('version') >= 2, [
                'category' => new CategoryResource($this->whenLoaded('category')),
            ]),
        ];
    }
}
```

It will become

```php
<?php

// In Controller
class PostController extends Controller
{
    public function index(User $user)
    {
        $posts = $user->posts()->latest()->simplePaginate();

        return PostResource::collection($posts);
    }
}

// In Resource
class PostResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'user' => new UserResource($this->whenLoaded('user')),
            $this->mergeWhen($request->header('Version') >= 2, [
                'category' => new CategoryResource($this->whenLoaded('category')),
            ]),
        ];
    }
}
```

To all controllers have one less parameters and instead of `$request->route('key')` it can be replaced with `$request->header('key')`.

### Conclusion

It possible to achieve API version with one code base but if you are a small team or a solo developer and you are implimenting this, there to be as simple as possible and avoid too much drastic changes. Also deprecate old functionality quickly so you would not have to maintain a lot of version at a time.

> Seen at tpyo? Feel free to make a PR with the correction.
