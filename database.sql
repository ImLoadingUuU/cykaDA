

CREATE TABLE `da_clients` (
  `username` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `activated` int(11) NOT NULL,
  `recover_code` int(11) DEFAULT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `da_website` (
  `username` text NOT NULL,
  `password` text NOT NULL,
  `suspended` text NOT NULL,
  `date_created` text NOT NULL,
  `client_email` text NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `da_clients`
  ADD PRIMARY KEY (`uid`);

ALTER TABLE `da_clients`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2113031616;
COMMIT;

