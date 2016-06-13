#### psd-munki-enroll

[munki-enroll](https://github.com/edingc/munki-enroll) files edited for use in the Portsmouth School Department

```
. /manifests
├── approved (Software for all computers goes here.) 
├── PHS 
│   ├── PHS_default (Any software specific to PMS goes here, includes approved manifest) 
│   └── 116 
|       ├── 116_default (Any software specific to Lab 116 goes here, includes PHS_default manifest)
|       └── computer1 (Software for computer1 goes here. Includes 116_default manifest, which includes PHS_default manifest.)
└── PMS
    ├── PMS_default (Any software specific to PMS goes here, includes approved manifest)
    └── a117
        ├── a117_default (Any software specific to Lab a117 goes here, includes PHS_default manifest)
        └── computer2 (Software for computer2 goes here. Includes A_default manifest, which includes default manifest.)
```

License

Munki Enroll, like the contained CFPropertyList project, is published under the MIT License.
