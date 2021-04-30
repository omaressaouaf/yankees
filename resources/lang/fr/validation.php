<?php

/*
|--------------------------------------------------------------------------
| Validation Language Lines
|--------------------------------------------------------------------------
|
| The following language lines contain the default error messages used by
| the validator class. Some of these rules have multiple versions such
| as the size rules. Feel free to tweak each of these messages here.
|
*/

return [
    'accepted'             => ':attribute doit être accepté.',
    'active_url'           => ':attribute n\'est pas une URL valide.',
    'after'                => ':attribute doit être une date postérieure au :date.',
    'after_or_equal'       => ':attribute doit être une date postérieure ou égale au :date.',
    'alpha'                => ':attribute doit contenir uniquement des lettres.',
    'alpha_dash'           => ':attribute doit contenir uniquement des lettres, des chiffres et des tirets.',
    'alpha_num'            => ':attribute doit contenir uniquement des chiffres et des lettres.',
    'array'                => ':attribute doit être un tableau.',
    'attached'             => ':attribute est déjà attaché(e).',
    'before'               => ':attribute doit être une date antérieure au :date.',
    'before_or_equal'      => ':attribute doit être une date antérieure ou égale au :date.',
    'between'              => [
        'array'   => 'tableau :attribute doit contenir entre :min et :max éléments.',
        'file'    => 'La taille du fichier de :attribute doit être comprise entre :min et :max kilo-octets.',
        'numeric' => 'La valeur de :attribute doit être comprise entre :min et :max.',
        'string'  => 'texte :attribute doit contenir entre :min et :max caractères.',
    ],
    'boolean'              => ':attribute doit être vrai ou faux.',
    'confirmed'            => 'de confirmation :attribute ne correspond pas.',
    'date'                 => ':attribute n\'est pas une date valide.',
    'date_equals'          => ':attribute doit être une date égale à :date.',
    'date_format'          => ':attribute ne correspond pas au format :format.',
    'different'            => ' champs :attribute et :other doivent être différents.',
    'digits'               => ':attribute doit contenir :digits chiffres.',
    'digits_between'       => ':attribute doit contenir entre :min et :max chiffres.',
    'dimensions'           => 'La taille de l\'image :attribute n\'est pas conforme.',
    'distinct'             => ':attribute a une valeur en double.',
    'email'                => ':attribute doit être une adresse email valide.',
    'ends_with'            => ':attribute doit se terminer par une des valeurs suivantes : :values',
    'exists'               => ':attribute sélectionné est invalide.',
    'file'                 => ':attribute doit être un fichier.',
    'filled'               => ':attribute doit avoir une valeur.',
    'gt'                   => [
        'array'   => 'tableau :attribute doit contenir plus de :value éléments.',
        'file'    => 'La taille du fichier de :attribute doit être supérieure à :value kilo-octets.',
        'numeric' => 'La valeur de :attribute doit être supérieure à :value.',
        'string'  => 'texte :attribute doit contenir plus de :value caractères.',
    ],
    'gte'                  => [
        'array'   => 'tableau :attribute doit contenir au moins :value éléments.',
        'file'    => 'La taille du fichier de :attribute doit être supérieure ou égale à :value kilo-octets.',
        'numeric' => 'La valeur de :attribute doit être supérieure ou égale à :value.',
        'string'  => 'texte :attribute doit contenir au moins :value caractères.',
    ],
    'image'                => ':attribute doit être une image.',
    'in'                   => ':attribute est invalide.',
    'in_array'             => ':attribute n\'existe pas dans :other.',
    'integer'              => ':attribute doit être un entier.',
    'ip'                   => ':attribute doit être une adresse IP valide.',
    'ipv4'                 => ':attribute doit être une adresse IPv4 valide.',
    'ipv6'                 => ':attribute doit être une adresse IPv6 valide.',
    'json'                 => ':attribute doit être un document JSON valide.',
    'lt'                   => [
        'array'   => 'tableau :attribute doit contenir moins de :value éléments.',
        'file'    => 'La taille du fichier de :attribute doit être inférieure à :value kilo-octets.',
        'numeric' => 'La valeur de :attribute doit être inférieure à :value.',
        'string'  => 'texte :attribute doit contenir moins de :value caractères.',
    ],
    'lte'                  => [
        'array'   => 'tableau :attribute doit contenir au plus :value éléments.',
        'file'    => 'La taille du fichier de :attribute doit être inférieure ou égale à :value kilo-octets.',
        'numeric' => 'La valeur de :attribute doit être inférieure ou égale à :value.',
        'string'  => 'texte :attribute doit contenir au plus :value caractères.',
    ],
    'max'                  => [
        'array'   => 'tableau :attribute ne peut contenir plus de :max éléments.',
        'file'    => 'La taille du fichier de :attribute ne peut pas dépasser :max kilo-octets.',
        'numeric' => 'La valeur de :attribute ne peut être supérieure à :max.',
        'string'  => 'texte de :attribute ne peut contenir plus de :max caractères.',
    ],
    'mimes'                => ':attribute doit être un fichier de type : :values.',
    'mimetypes'            => ':attribute doit être un fichier de type : :values.',
    'min'                  => [
        'array'   => 'tableau :attribute doit contenir au moins :min éléments.',
        'file'    => 'La taille du fichier de :attribute doit être supérieure à :min kilo-octets.',
        'numeric' => 'La valeur de :attribute doit être supérieure ou égale à :min.',
        'string'  => 'texte :attribute doit contenir au moins :min caractères.',
    ],
    'multiple_of'          => 'La valeur de :attribute doit être un multiple de :value',
    'not_in'               => ':attribute sélectionné n\'est pas valide.',
    'not_regex'            => 'format du :attribute n\'est pas valide.',
    'numeric'              => ':attribute doit contenir un nombre.',
    'password'             => 'mot de passe est incorrect',
    'present'              => ':attribute doit être présent.',
    'prohibited'           => ':attribute est interdit.',
    'prohibited_if'        => ':attribute est interdit quand :other a la valeur :value.',
    'prohibited_unless'    => ':attribute est interdit à moins que :other est l\'une des valeurs :values.',
    'regex'                => 'format du :attribute est invalide.',
    'relatable'            => ':attribute n\'est sans doute pas associé(e) avec cette donnée.',
    'required'             => ':attribute est obligatoire.',
    'required_if'          => ':attribute est obligatoire quand la valeur de :other est :value.',
    'required_unless'      => ':attribute est obligatoire sauf si :other est :values.',
    'required_with'        => ':attribute est obligatoire quand :values est présent.',
    'required_with_all'    => ':attribute est obligatoire quand :values sont présents.',
    'required_without'     => ':attribute est obligatoire quand :values n\'est pas présent.',
    'required_without_all' => ':attribute est requis quand aucun de :values n\'est présent.',
    'same'                 => ' champs :attribute et :other doivent être identiques.',
    'size'                 => [
        'array'   => 'tableau :attribute doit contenir :size éléments.',
        'file'    => 'La taille du fichier de :attribute doit être de :size kilo-octets.',
        'numeric' => 'La valeur de :attribute doit être :size.',
        'string'  => 'texte de :attribute doit contenir :size caractères.',
    ],
    'starts_with'          => ':attribute doit commencer avec une des valeurs suivantes : :values',
    'string'               => ':attribute doit être une chaîne de caractères.',
    'timezone'             => ':attribute doit être un fuseau horaire valide.',
    'unique'               => 'La valeur du :attribute est déjà utilisée.',
    'uploaded'             => 'fichier du :attribute n\'a pu être téléversé.',
    'url'                  => 'format de l\'URL de :attribute n\'est pas valide.',
    'uuid'                 => ':attribute doit être un UUID valide',
    "isBetweenTheMinAndAdminSelectedOptions" => ":attribute doit être compris entre le min et la somme des options",


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */
    'custom'=> [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */
    'attributes'           => [
        "name" => "Le Nom",
        "email" => "l'Email",
        "address" => "l'Adresse",
        "phone" => "Le Numéro de Téléphone",
        "password" => "Le Mot de passe",
        "is_admin" => "Est Admin",
        'slug'=> "Le Slug",
        'title'=> 'Le Titre',
        'price'=> "Le Prix",
        "description"=> "La Description",
        "image"=> "l'Image",
        'category_id'=> "La Catégorie",
        "min"=> "Le Min",
        "max"=> "Le Max",
        "time"=> "Le Temps",
        "tax"=> "Le Taux d'imposition",
        "start"=> "Heure de début",
        "end"=> "Heure de fin",
        "label"=> "Le Label",
        "roles" => "Les Rôles",
        "content" => "Le Contenu"

    ],
];
