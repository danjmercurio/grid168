module OutletsHelper

	# def outlet_types
	# 	[
	# 		["Broadcast", 1],
	# 		["Cable system", 2],
	# 		["Network", 3],
	# 		["Sub channel", 4]
	# 	]
	# end #end outlet_types

	def get_type(index)
		result = ""
		outlet_types.each do |k, v|
			if v == index
				result = k
				break
			end
		end

		result
	end #end get_type

	def convert2Decimal(number)
		num, dec = number.split(".")
		if dec.length < 2
			dec += "0"
		end
		num + "." + dec
	end #end convert2Decimal
end
