# nukeCE Subsystem Map (v11)
Generated: 2025-12-26T23:50:06.990347Z

## Principle
- **Subsystems live in `public_html/src/`**.
- Modules (`public_html/modules/`) should be thin routing + UI glue over subsystems.

## Subsystems present
### src/AI/ (5 PHP files)
Representative files:
- `AiEventLog.php`
- `AiService.php`
- `AiSettings.php`
- `OpenAIProvider.php`
- `Providers.php`

### src/Blocks/ (1 PHP files)
Representative files:
- `BlockManager.php`

### src/Core/ (17 PHP files)
Representative files:
- `AdminLayout.php`
- `AdminUi.php`
- `AppConfig.php`
- `Controller.php`
- `Device.php`
- `Entitlements.php`
- `Labels.php`
- `Layout.php`
- `Maintenance.php`
- `MobileMode.php`
- `Model.php`
- `ModuleInterface.php`
- `ModuleManager.php`
- `Router.php`
- `SiteConfig.php`
- `Theme.php`
- `UpdateAI.php`

### src/Editor/ (1 PHP files)
Representative files:
- `EditorService.php`

### src/Forums/ (1 PHP files)
Representative files:
- `PrivateMessages/PrivateMessagesBridge.php`

### src/Moderation/ (1 PHP files)
Representative files:
- `ModerationQueue.php`

### src/Security/ (8 PHP files)
Representative files:
- `AuthGate.php`
- `CapabilityGate.php`
- `Csrf.php`
- `GeoIp.php`
- `NukeSecurity.php`
- `NukeSecurityConfig.php`
- `PackageScanner.php`
- `UserAuth.php`

