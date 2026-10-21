export const MAX_LINES = 800;
export function codeSnippet(language, {serverUrl, items}) {
    if (!items || !items.length) {
        return 'Select items to download'
    }
    const isTrauncate = items.length > MAX_LINES - 1
    const curlSnippet = `#!/bin/bash

${(function () { return items
        .slice(0, MAX_LINES)
        .map(item=>`curl -o "${item.fn}" -s --show-error "${item.loadUri}"`).join('\n') }())}

${isTrauncate ? 'echo "Список загрузки ограничен UI"':''}    
echo "Загрузка завершена."

    
    `
    const goSnippet = `package tradesdownload

import (
    "io"
    "net/http"
    "os"
)

func main() {
    files := []struct{ URL, Name string }{
${(function () { return items
    .slice(0, MAX_LINES)
    .map(item=>`        {"${item.loadUri}", "${item.fn}"},`).join('\n') }())}
    }
${isTrauncate ? '// Список загрузки ограничен':''}  
    for _, f := range files {
        go func(url, name string) {
            res, _ := http.Get(url)
            if res != nil && res.StatusCode == 200 {
                data, _ := os.Create(name)
                io.Copy(data, res.Body)
                data.Close()
                res.Body.Close()
            }
        }(f.URL, f.Name)
    }

    select{}
}

    `
    const javaSnippet = `import okhttp3.*;
import java.io.*;
import java.util.*;
import java.nio.file.*;

public class FileDownloader {
    public static void main(String[] args) throws Exception {
        List<Map.Entry<String, String>> files = Arrays.asList(
${(function () { return items
    .slice(0, MAX_LINES)
    .map(item=>`            Map.entry("${item.loadUri}", "${item.fn}")`).join(',\n') }())}
        );
${isTrauncate ? '// Список загрузки ограничен UI':''}  
        OkHttpClient client = new OkHttpClient();
        
        for (Map.Entry<String, String> entry : files) {
            Request request = new Request.Builder().url(entry.getKey()).build();
            Response response = client.newCall(request).execute();
            if (response.isSuccessful() && response.body() != null) {
                try (InputStream is = response.body().byteStream()) {
                    Files.copy(is, Paths.get(entry.getValue()), StandardCopyOption.REPLACE_EXISTING);
                }
            }
        }
    }
}
`



    const nodeSnippet = `const axios = require('axios');
const { createWriteStream } = require('fs');
const { join } = require('path');

const files = [
${(function () { return items
    .slice(0, MAX_LINES)
    .map(item=>`  { url: '${item.loadUri}', filename: '${item.fn}' }`).join(',\n') }())}
];
${isTrauncate ? '// Список загрузки ограничен UI':''}  
files.forEach(async ({ url, filename }) => {
  const res = await axios.get(url, { responseType: 'stream' });
  res.data.pipe(createWriteStream(filename));
}); 
    `


    const phpSnippet = `<?php

$files = [
${(function () { return items
    .slice(0, MAX_LINES)
    .map(item=>`    ['${item.loadUri}', '${item.fn}'],`).join('\n') }())}
];
${isTrauncate ? '// Список загрузки ограничен UI':''}  
foreach ($files as [$url, $filename]) {
    $fp = fopen($filename, 'w');
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);
}
`

    const pythonSnippet = `import requests

files = [
${(function () { return items
    .slice(0, MAX_LINES)
    .map(item=>`    ('${item.loadUri}', '${item.fn}'),`).join('\n') }())}
]
${isTrauncate ? '# Список загрузки ограничен UI':''}  
for url, filename in files:
    with open(filename, 'wb') as f:
        f.write(requests.get(url).content)    
`
    const snippet = ''
    switch (language) {
        case 'curl':
            return curlSnippet;
        case 'go':
            return goSnippet;
        case 'java':
            return javaSnippet;
        case 'nodejs':
            return nodeSnippet;
        case 'php':
            return phpSnippet;
        case 'python':
            return pythonSnippet;
        default:
            return snippet;
    }
}