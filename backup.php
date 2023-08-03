<?php

$projects = GetProjects();
$groups = GetGroups();

$items = array_unique(array_merge($projects,$groups));

foreach($items as $item) {
    $url = parse_url($item);
    $url = $url['scheme']."://oauth2:".getenv("GITLAB_TOKEN")."@".$url["host"].$url["path"];
    print "git clone $url \r\n";
    exec("git clone $url");
}

function GetProjects() {

    $url = getenv("GITLAB_HOST")."/api/v4/projects";
    $header = "PRIVATE-TOKEN: ".getenv("GITLAB_TOKEN")."\r\n";
    $method = "GET";

    $ctx = stream_context_create([
        "http" => [
            "header" => $header,
            "method" => $method,
        ]
    ]);

    $result = file_get_contents($url,false,$ctx);
    $x = json_decode($result);

    $output = [];
    foreach($x as $item) {
        // var_dump($item);
        $output[] = $item->http_url_to_repo;
    }

    return $output;
}

function GetGroups() {
    // for repo in $(curl -s --header "PRIVATE-TOKEN: $GITLAB_TOKEN" $GITLAB_HOST/api/v4/groups/sacredheart | jq -r ".projects[].ssh_url_to_repo"); do git clone $repo; done;

    $url = getenv("GITLAB_HOST")."/api/v4/groups/sacredheart";
    $header = "PRIVATE-TOKEN: ".getenv("GITLAB_TOKEN")."\r\n";
    $method = "GET";

    $ctx = stream_context_create([
        "http" => [
            "header" => $header,
            "method" => $method,
        ]
    ]);

    $result = file_get_contents($url,false,$ctx);
    $x = json_decode($result);

    $output = [];

    foreach($x->projects as $group) {
        // var_dump($group->http_url_to_repo);
        $output[] = $group->http_url_to_repo;
    }

    return $output;
}
