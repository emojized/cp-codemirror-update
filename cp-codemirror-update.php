<?php
/*
 * Plugin Name:       CodeMirror Update 
 * Plugin URI:        https://github.com/emojized/cp-codemirror-update
 * Description:       Replacing the WP/CP Code Editor with the newer CodeMirror Editor
 * Version:           1.0
 * Requires at least: 4.9.15
 * Requires PHP:      7.4
 * Requires CP:       2.2
 * Author:            The emojized Team
 * Author URI:        https://emojized.com
 * License:           GPL v2 and MIT
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
*/


/*
Integrating WordPress-specific functions directly into the CodeMirror
JavaScript library is considered poor practice for several reasons.
Firstly, it tightly couples the CodeMirror library with
WordPress-specific functionality, which can lead to issues with
maintainability and scalability. When WordPress-specific code is
embedded within a general-purpose library like CodeMirror, updating or
replacing the library becomes significantly more complex. This is
because any update to the CodeMirror library would require a careful
review to ensure that the WordPress-specific enhancements are not lost
or broken by the new version.

Furthermore, embedding WordPress-specific functions within CodeMirror
violates the principle of separation of concerns. CodeMirror is designed
to be a versatile text editor implemented in JavaScript, independent of
any particular platform or framework. By mixing in WordPress-specific
code, the clarity and reusability of the CodeMirror library are
compromised. Other developers who might want to use CodeMirror in a
different context (not WordPress) would find the library less useful or
would have to modify it to remove the WordPress-specific code, which
could be error-prone and time-consuming.

Lastly, such integration can lead to difficulties in debugging and
testing. Issues could arise either from the CodeMirror side or the
WordPress-specific additions, and disentangling these could be
challenging. It would be harder to isolate whether issues are due to the
core CodeMirror functionality or the added WordPress functions,
complicating both the development and maintenance processes. */

/*
On wp-includes/script-loader.php Line 990 we can read, that WordPress /
ClassicPress includes CodeMirror 5.29.1-alpha-ee20357

it had a vulnerability related to Regular Expression Denial of Service
(ReDoS) The vulnerable regular expression was located in the
JavaScript mode However, this issue was addressed in subsequent
releases. For example, version 5.65.17, which was published on July 20,
2024, does not have this vulnerability 2. If you’re using CodeMirror,
make sure to keep it updated to avoid security risks. 

https://security.snyk.io/package/maven/org.webjars.npm:codemirror/5.23.0
https://security.snyk.io/package/npm/codemirror

 */


function emojized_codemirror_deregister_all_scripts() {
    // Deregister each script

    // tried it easy by rejecting the original codemirror in wp
    wp_deregister_script('wp-codemirror');
   /* wp_deregister_script('csslint');
    wp_deregister_script('esprima');
    wp_deregister_script('jshint');
    wp_deregister_script('jsonlint');
    wp_deregister_script('htmlhint');
    wp_deregister_script('htmlhint-kses');
    wp_deregister_script('code-editor');
    wp_deregister_script('wp-theme-plugin-editor');*/
}
add_action('admin_enqueue_scripts', 'emojized_codemirror_deregister_all_scripts', 100);

function emojized_codemirror_admin_script() {
    // Check if we are in the admin area
    if (is_admin()) {
        // Register and enqueue the script

        // WP 6.5 hould have wp_enqueue_script_module

        wp_enqueue_script(
            'wp-codemirror', // Handle for the script
            'https://cdn.jsdelivr.net/npm/codemirror@5.65.17/lib/codemirror.js',
            // URL to the codemirror.js in the CDN , because of the problems mentioned above, this is not possible right now
            array(), // No dependencies
            null, // Version number
            false // Load in footer
        );
    }
}
// Hook into the admin_enqueue_scripts action
add_action('admin_enqueue_scripts', 'emojized_codemirror_admin_script');

