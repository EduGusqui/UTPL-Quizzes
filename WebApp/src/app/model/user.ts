import { Rol } from './rol';

export class User {
	constructor(
		public Id?: number,
		public FullName?: string,
		public Identification?: string,
		public Email?: string,
		public Phone?: string,
		public ResidenceCity?: string,
		public Username?: string,
		public Status?: string,
		public Rol?: Rol
	) {}
}