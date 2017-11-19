CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(60) NOT NULL,
  `hasAvatar` int(11) DEFAULT '0',
  `imgData` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

CREATE TABLE `tour` (
  `id` int(11) NOT NULL,
  `TenTour` varchar(255) NOT NULL,
  `MaTour` varchar(50) NOT NULL,
  `imgData` mediumblob NOT NULL,
  `Gia` int(11) NOT NULL,
  `Diem` int(11) NOT NULL,
  `SoNgay` int(11) NOT NULL,
  `SoCho` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `tour`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tour`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;