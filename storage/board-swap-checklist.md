Board swap — Faulty board → Refurbished board

Overview

Follow the return → refurbished-stock → transfer → accept → assign flow so records remain auditable and telemetry/history is preserved.

Replace smarteclipse.com with your site host (e.g. smarteclipse.com).

Step 1 — Log the faulty board return

- Create (quick return): https://smarteclipse.com/direct-device-return
- Return history / list: https://smarteclipse.com/device-return-history-list

What to enter
- Return code (auto or manual)
- Device IMEI or Serial (faulty board)
- Servicer (technician logging return)
- Client (end-customer)
- Type of issues and comments

Verify
- Device Return entry appears in returns list with IMEI/Serial
- `servicer` field equals technician who logged it
- `status = 0` (awaiting processing)

Step 2 — Add the refurbished board (if not already in DB)

- Add device page: https://smarteclipse.com/gps/create
- All devices list: https://smarteclipse.com/gps-all

What to enter
- IMEI, Serial, Model, Version, Manufacturing Date
- Mark or ensure `refurbished_status = 1` (refurbished)

Verify
- New IMEI/Serial appears on `/gps-all` when filtering Refurbished
- Device record shows correct fields and refurbished flag

Step 3 — Put refurbished board into stock

- In-stock page (stock listing / add actions): https://smarteclipse.com/gps
- Device details: https://smarteclipse.com/gps/{encryptedId}/details

What to do
- Add gps.id to `gps_stocks` with `inserted_by` and `refurbished_status = 1`

Verify
- Device appears in stock with refurbished indicator
- `inserted_by` set to manufacturer/root or appropriate user
- No vehicle assignment in stock entry

Step 4 — Transfer refurbished board to service/technician

- Create transfer: https://smarteclipse.com/gps-transfer-root
- Transfer list: https://smarteclipse.com/gps-transferred-root

What to do
- Create `GpsTransfer` from stock owner to receiver
- Add refurbished GPS as transfer item, set order/invoice as needed, dispatch

Verify
- Transfer exists with `dispatched_on` populated
- Transfer item lists the IMEI/serial
- Status `accepted_on = null` until receiver accepts

Step 5 — Accept the transfer (receiver)

- Pending/accept transfers: https://smarteclipse.com/gps-transferred-root

What to do
- Receiver reviews transfer and marks Accept (sets `accepted_on`)

Verify
- `accepted_on` timestamp present
- `gps_stocks` ownership updated to the receiver (dealer/subdealer/client)
- Device now visible under receiver's stock

Step 6 — Assign the refurbished board to the vehicle

- Vehicle edit / assign: https://smarteclipse.com/vehicle/{vehicleId}/edit
- Or assign from device details: https://smarteclipse.com/gps/{encryptedId}/details

What to do
- Assign the refurbished GPS to the vehicle (select IMEI / device and save)

Verify
- Vehicle page shows new IMEI/serial and `gps_id` updated
- Device `vehicle` relation points to vehicle and `vehicle_no` is set
- Faulty device record remains separate and unassigned

Step 7 — Mark faulty board returned into stock / close return

- Stock: https://smarteclipse.com/gps
- Device return history/list: https://smarteclipse.com/device-return-history-list

What to do
- Remove faulty board from vehicle (unassign/replace)
- Create stock return or update `gps_stocks` to set `is_returned = 1` and `returned_on`
- Link/update `DeviceReturn` from Step 1 to closed/processed status

Verify
- `DeviceReturn` status updated/closed
- `gps_stocks` entry for faulty gps has `is_returned = 1` and `returned_on` set
- Historical telemetry remains on original `gps.id`

Step 8 — Post-swap audit & telemetry checks

- All devices: https://smarteclipse.com/gps-all
- Stock & transfer reports: https://smarteclipse.com/gps and https://smarteclipse.com/gps-transferred-root

Verify checklist
- Faulty device record still exists (search IMEI on `/gps-all`)
- Faulty device telemetry/history remains tied to original `gps.id`
- Refurbished device shows under vehicle and begins reporting telemetry (if powered)
- Transfer and return records have timestamps for dispatched/accepted/returned
- Warranty certificate/invoice attached to refurbished device if needed

Quick pointers (code references)
- `createRefurbishedGps` in `app/Modules/Gps/Models/Gps.php`
- `createRefurbishedGpsInStock` in `app/Modules/Warehouse/Models/GpsStock.php`
- `DeviceReturn` model: `app/Modules/DeviceReturn/Models/DeviceReturn.php`
- Transfer models: `app/Modules/Gps/Models/GpsTransfer.php` and `GpsTransferItems`

Notes / Best Practices
- Do NOT overwrite the original `gps` row's IMEI/serial — create a new `gps` record for the refurbished board so telemetry and audit trail remain intact.
- Use `DeviceReturn` + `GpsStock` + `GpsTransfer` flows rather than direct mutation.
- Perform actions with the appropriate role (servicer, warehouse/root, distributor) as UI permissions require.

End of checklist
