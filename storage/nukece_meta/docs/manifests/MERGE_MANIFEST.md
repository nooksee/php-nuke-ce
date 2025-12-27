# nukeCE merged build (pre-B2)

Built: 2025-12-25T01:07:09Z (UTC)

## Base
- nukece_phase2_adminui_nukesecurity_settings_moderation.zip

## Overlays applied (in order)
1. nukece_omnibus_with_geoip_country_rules_enforcement.zip (selective: full overlay)
2. nukece_nukesecurity_datafeeds_scaffold.zip (overlay)
3. nukece_admin_maintenance_gold.zip (overlay)
4. nukece_attribution_repaired_with_credits_module.zip (overlay)
5. nukece_links_coreblocks_patch.zip (overlay)
6. nukece_c1_core_blocks_gold_pass_patch.zip (overlay)
7. nukece_links_blocks_queue_top_reference_patch.zip (overlay)
8. nukece_links_admin_queue_propose_reference_patch.zip (overlay)
9. nukece_omnibus_with_clubs_and_reference_queue_v1.zip (selective: clubs + admin_clubs + admin_reference + TopClubs block + icons + docs)
10. nukece_omnibus_gold_ai_reference_polish_release.zip (selective: src/AI + modules/admin_ai + docs/AI_SUBSYSTEM + ai icons + UpdateAI)
11. nukece_ubuntu_desktop_runner.zip (overlay)

## Notes
- Two "omnibus" zips were **NOT** fully overlaid to avoid clobbering Phase2 core; only the relevant feature paths listed above were extracted.
- GeoIP enforcement was fully overlaid because it is mostly additive (src/Security/GeoIp.php + docs). If you observe regressions, we can switch this to selective extraction.

## Next
- Proceed with B2 Newsletter (module + subscribe block), then queue ShareKit (News + Pages).
